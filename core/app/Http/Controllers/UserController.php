<?php

namespace App\Http\Controllers;

use App\Lib\GoogleAuthenticator;
use App\Models\AdminNotification;
use App\Models\BvLog;
use App\Models\Deposit;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawMethod;
use App\Models\Withdrawal;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function home()
    {
        $pageTitle = 'Dashboard';
        $totalDeposit       = Deposit::where('user_id', auth()->id())->where('status', 1)->sum('amount');
        $totalWithdraw      = Withdrawal::where('user_id', auth()->id())->where('status', 1)->sum('amount');
        $completeWithdraw   = Withdrawal::where('user_id', auth()->id())->where('status', 1)->count();
        $pendingWithdraw    = Withdrawal::where('user_id', auth()->id())->where('status', 2)->count();
        $rejectWithdraw     = Withdrawal::where('user_id', auth()->id())->where('status', 3)->count();
        $totalRef          = User::where('ref_id', auth()->id())->count();
        $totalBvCut         = BvLog::where('user_id', auth()->id())->where('trx_type', '-')->sum('amount');
        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle','totalDeposit','totalWithdraw','completeWithdraw','pendingWithdraw','rejectWithdraw','totalRef','totalBvCut'));
    }

    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = Auth::user();
        return view($this->activeTemplate. 'user.profile_setting', compact('pageTitle','user'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => 'sometimes|required|max:80',
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
            'image' => ['image',new FileTypeValidate(['jpg','jpeg','png'])]
        ],[
            'firstname.required'=>'First name field is required',
            'lastname.required'=>'Last name field is required'
        ]);

        $user = Auth::user();

        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
        ];


        if ($request->hasFile('image')) {
            $location = imagePath()['profile']['user']['path'];
            $size = imagePath()['profile']['user']['size'];
            $filename = uploadImage($request->image, $location, $size, $user->image);
            $in['image'] = $filename;
        }
        $user->fill($in)->save();
        $notify[] = ['success', 'Profile updated successfully.'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {

        $password_validation = Password::min(6);
        $general = GeneralSetting::first();
        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required','confirmed',$password_validation]
        ]);


        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'Password changes successfully.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'The password doesn\'t match!'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    /*
     * Deposit History
     */
    public function depositHistory()
    {
        $pageTitle = 'Deposit History';
        $emptyMessage = 'No history found.';
        $logs = auth()->user()->deposits()->with(['gateway'])->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.deposit_history', compact('pageTitle', 'emptyMessage', 'logs'));
    }

    /*
     * Withdraw Operation
     */

    public function withdrawMoney()
    {
        $withdrawMethod = WithdrawMethod::where('status',1)->get();
        $pageTitle = 'Withdraw Money';
        return view($this->activeTemplate.'user.withdraw.methods', compact('pageTitle','withdrawMethod'));
    }

    public function withdrawStore(Request $request)
    {
        $this->validate($request, [
            'method_code' => 'required',
            'amount' => 'required|numeric'
        ]);
        $method = WithdrawMethod::where('id', $request->method_code)->where('status', 1)->firstOrFail();
        $user = auth()->user();
        if ($request->amount < $method->min_limit) {
            $notify[] = ['error', 'Your requested amount is smaller than minimum amount.'];
            return back()->withNotify($notify);
        }
        if ($request->amount > $method->max_limit) {
            $notify[] = ['error', 'Your requested amount is larger than maximum amount.'];
            return back()->withNotify($notify);
        }

        if ($request->amount > $user->balance) {
            $notify[] = ['error', 'You do not have sufficient balance for withdraw.'];
            return back()->withNotify($notify);
        }


        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;
        $finalAmount = $afterCharge * $method->rate;

        $withdraw = new Withdrawal();
        $withdraw->method_id = $method->id; // wallet method ID
        $withdraw->user_id = $user->id;
        $withdraw->amount = $request->amount;
        $withdraw->currency = $method->currency;
        $withdraw->rate = $method->rate;
        $withdraw->charge = $charge;
        $withdraw->final_amount = $finalAmount;
        $withdraw->after_charge = $afterCharge;
        $withdraw->trx = getTrx();
        $withdraw->save();
        session()->put('wtrx', $withdraw->trx);
        return redirect()->route('user.withdraw.preview');
    }

    public function withdrawPreview()
    {
        $withdraw = Withdrawal::with('method','user')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id','desc')->firstOrFail();
        $pageTitle = 'Withdraw Preview';
        return view($this->activeTemplate . 'user.withdraw.preview', compact('pageTitle','withdraw'));
    }


    public function withdrawSubmit(Request $request)
    {
        $general = GeneralSetting::first();
        $withdraw = Withdrawal::with('method','user')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id','desc')->firstOrFail();

        $rules = [];
        $inputField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($withdraw->method->user_data as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], new FileTypeValidate(['jpg','jpeg','png']));
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }

        $this->validate($request, $rules);

        $user = auth()->user();
        if ($user->ts) {
            $response = verifyG2fa($user,$request->authenticator_code);
            if (!$response) {
                $notify[] = ['error', 'Wrong verification code'];
                return back()->withNotify($notify);
            }
        }


        if ($withdraw->amount > $user->balance) {
            $notify[] = ['error', 'Your request amount is larger then your current balance.'];
            return back()->withNotify($notify);
        }

        $directory = date("Y")."/".date("m")."/".date("d");
        $path = imagePath()['verify']['withdraw']['path'].'/'.$directory;
        $collection = collect($request);
        $reqField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($collection as $k => $v) {
                foreach ($withdraw->method->user_data as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory.'/'.uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $request[$inKey]];
                                    return back()->withNotify($notify)->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $withdraw['withdraw_information'] = $reqField;
        } else {
            $withdraw['withdraw_information'] = null;
        }


        $withdraw->status = 2;
        $withdraw->save();
        $user->balance  -=  $withdraw->amount;
        $user->save();



        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = $withdraw->charge;
        $transaction->trx_type = '-';
        $transaction->details = showAmount($withdraw->final_amount) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name;
        $transaction->trx =  $withdraw->trx;
        $transaction->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New withdraw request from '.$user->username;
        $adminNotification->click_url = urlPath('admin.withdraw.details',$withdraw->id);
        $adminNotification->save();

        notify($user, 'WITHDRAW_REQUEST', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount),
            'amount' => showAmount($withdraw->amount),
            'charge' => showAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => showAmount($user->balance),
            'delay' => $withdraw->method->delay
        ]);

        $notify[] = ['success', 'Withdraw request sent successfully'];
        return redirect()->route('user.withdraw.history')->withNotify($notify);
    }

    public function withdrawLog()
    {
        $pageTitle = "Withdraw Log";
        $withdraws = Withdrawal::where('user_id', Auth::id())->where('status', '!=', 0)->with('method')->orderBy('id','desc')->paginate(getPaginate());
        $data['emptyMessage'] = "No Data Found!";
        return view($this->activeTemplate.'user.withdraw.log', compact('pageTitle','withdraws'));
    }



    public function show2faForm()
    {
        $general = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->sitename, $secret);
        $pageTitle = 'Two Factor';
        return view($this->activeTemplate.'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user,$request->code,$request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Google authenticator enabled successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }


    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user,$request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Two factor authenticator disable successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }


    public function indexTransfer()
    {
        $pageTitle = 'Balance Transfer';
        return view($this->activeTemplate . '.user.balanceTransfer', compact('pageTitle'));
    }

    public function balanceTransfer(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'amount' => 'required|numeric|min:0',
        ]);
        $gnl = GeneralSetting::first();
        $user = User::find(Auth::id());
        $trans_user = User::where('username', $request->username)->orWhere('email', $request->username)->first();
        if ($trans_user == '') {
            $notify[] = ['error', 'Username Not Found'];
            return back()->withNotify($notify);
        }
        if ($trans_user->username == $user->username) {
            $notify[] = ['error', 'Balance Transfer Not Possible In Your Own Account'];
            return back()->withNotify($notify);
        }
        if ($trans_user->email == $user->email) {
            $notify[] = ['error', 'Balance Transfer Not Possible In Your Own Account'];
            return back()->withNotify($notify);
        }

        $charge = $gnl->bal_trans_fixed_charge + (($request->amount * $gnl->bal_trans_per_charge) / 100);
        $amount = $request->amount + $charge;
        if ($user->balance >= $amount) {
            $user->balance -= $amount;
            $user->save();

            $trx = getTrx();

            Transaction::create([
                'trx' => $trx,
                'user_id' => $user->id,
                'trx_type' => '-',
                'remark' => 'balance_transfer',
                'details' => 'Balance Transferred To ' . $trans_user->username,
                'amount' => getAmount($request->amount),
                'post_balance' => getAmount($user->balance),
                'charge' => $charge
            ]);

            notify($user, 'BAL_SEND', [
                'amount' => getAmount($request->amount),
                'username' => $trans_user->username,
                'trx' => $trx,
                'currency' => $gnl->cur_text,
                'charge' => getAmount($charge),
                'balance_now' => getAmount($user->balance),
            ]);

            $trans_user->balance += $request->amount;
            $trans_user->save();

            Transaction::create([
                'trx' => $trx,
                'user_id' => $trans_user->id,
                'remark' => 'balance_receive',
                'details' => 'Balance receive From ' . $user->username,
                'amount' => getAmount($request->amount),
                'post_balance' => getAmount($trans_user->balance),
                'charge' => 0,
                'trx_type' => '+'
            ]);

            notify($trans_user, 'BAL_RECEIVE', [
                'amount' => getAmount($request->amount),
                'currency' => $gnl->cur_text,
                'trx' => $trx,
                'username' => $user->username,
                'charge' => 0,
                'balance_now' => getAmount($trans_user->balance),
            ]);

            $notify[] = ['success', 'Balance Transferred Successfully.'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Insufficient Balance.'];
            return back()->withNotify($notify);

        }
    }


    public function searchUser(Request $request)
    {
        $trans_user = User::where('username', $request->username)->orwhere('email', $request->username)->count();
        if ($trans_user == 1) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function purchase(Request $request){
        $request->validate([
            'quantity'=>'required|integer|gt:0',
            'product_id'=>'required|integer|gt:0'
        ]);
        $product = Product::hasCategory()->where('status',1)->findOrFail($request->product_id);
        if($request->quantity > $product->quantity){
            $notify[] = ['error','Requested quantity is not available in stock'];
            return back()->withNotify($notify);
        }
        $user = auth()->user();
        $totalPrice = $product->price * $request->quantity;
        if($user->balance < $totalPrice){
            $notify[] = ['error','Balance is not sufficient'];
            return back()->withNotify($notify);
        }
        $user->balance -= $totalPrice;
        $user->save();

        $product->quantity -= $request->quantity;
        $product->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $totalPrice;
        $transaction->post_balance = $user->balance;
        $transaction->charge = 0;
        $transaction->trx_type = '-';
        $transaction->details = $product->name.' item purchase';
        $transaction->trx =  getTrx();
        $transaction->save();

        $order = new Order();
        $order->user_id = $user->id;
        $order->product_id = $product->id;
        $order->quantity = $request->quantity;
        $order->price = $product->price;
        $order->total_price = $totalPrice;
        $order->trx = $transaction->trx;
        $order->status = 0;
        $order->save();

        $general = GeneralSetting::first();
        notify($user,'order_placed',[
            'product_name'=>$product->name,
            'quantity'=>$request->quantity,
            'price'=>showAmount($product->price),
            'total_price'=>showAmount($totalPrice),
            'currency'=>$general->cur_text,
            'trx'=>$transaction->trx,
        ]);

        $notify[] = ['success','Order placed successfully'];
        return back()->withNotify($notify);

    }

    public function orders(){
        $pageTitle = 'Orders';
        $orders = Order::where('user_id',auth()->user()->id)->with('product')->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.orders',compact('pageTitle','orders'));
    }


}
