<?php

namespace App\Http\Controllers;

use App\Models\BvLog;
use App\Models\GeneralSetting;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserExtra;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    function planIndex()
    {
        $pageTitle = "Plans";
        $plans = Plan::where('status',1)->get();
        return view($this->activeTemplate . '.user.plan',compact('pageTitle','plans'));

    }

    function planStore(Request $request)
    {
        $this->validate($request, ['plan_id' => 'required|integer']);
        $plan = Plan::where('id', $request->plan_id)->where('status', 1)->firstOrFail();
        $gnl = GeneralSetting::first();

        $user = auth()->user();

        if ($user->balance < $plan->price) {
            $notify[] = ['error', 'Insufficient Balance'];
            return back()->withNotify($notify);
        }

        $oldPlan = $user->plan_id;
        $user->plan_id = $plan->id;
        $user->balance -= $plan->price;
        $user->total_invest += $plan->price;
        $user->save();

        $trx = new Transaction();
        $trx->user_id = $user->id;
        $trx->amount = $plan->price;
        $trx->trx_type = '-';
        $trx->details = 'Purchased ' . $plan->name;
        $trx->remark = 'purchased_plan';
        $trx->trx = getTrx();
        $trx->post_balance = getAmount($user->balance);
        $trx->save();

        notify($user, 'plan_purchased', [
            'plan' => $plan->name,
            'amount' => getAmount($plan->price),
            'currency' => $gnl->cur_text,
            'trx' => $trx->trx,
            'post_balance' => getAmount($user->balance) . ' ' . $gnl->cur_text,
        ]);
        if ($oldPlan == 0) {
            updatePaidCount($user->id);
        }
        $details = auth()->user()->username . ' Subscribed to ' . $plan->name . ' plan.';

        updateBV($user->id, $plan->bv, $details);

        if ($plan->tree_com > 0) {
            treeComission($user->id, $plan->tree_com, $details);
        }

        referralComission($user->id, $details);

        $notify[] = ['success', 'Purchased ' . $plan->name . ' Successfully'];
        return redirect()->route('user.home')->withNotify($notify);

    }


    public function binaryCom()
    {
        $pageTitle = "Binary Commission";
        $logs = Transaction::where('user_id', auth()->id())->where('remark', 'binary_commission')->orderBy('id', 'DESC')->paginate(getPaginate());
        $emptyMessage = 'No data found';
        return view($this->activeTemplate . '.user.transactions',compact('pageTitle','logs','emptyMessage'));
    }

    public function binarySummery()
    {
        $pageTitle = "Binary Summery";
        $logs = UserExtra::where('user_id', auth()->id())->firstOrFail();
        return view($this->activeTemplate . '.user.binarySummery',compact('pageTitle','logs'));
    }

    public function bvlog(Request $request)
    {

        if ($request->type) {
            if ($request->type == 'leftBV') {
                $pageTitle = "Left BV";
                $logs = BvLog::where('user_id', auth()->id())->where('position', 1)->where('trx_type', '+')->orderBy('id', 'desc')->paginate(getPaginate());
            } elseif ($request->type == 'rightBV') {
                $pageTitle = "Right BV";
                $logs = BvLog::where('user_id', auth()->id())->where('position', 2)->where('trx_type', '+')->orderBy('id', 'desc')->paginate(getPaginate());
            } elseif ($request->type == 'cutBV') {
                $pageTitle = "Cut BV";
                $logs = BvLog::where('user_id', auth()->id())->where('trx_type', '-')->orderBy('id', 'desc')->paginate(getPaginate());
            } else {
                $pageTitle = "All Paid BV";
                $logs = BvLog::where('user_id', auth()->id())->where('trx_type', '+')->orderBy('id', 'desc')->paginate(getPaginate());
            }
        } else {
            $pageTitle = "BV LOG";
            $logs = BvLog::where('user_id', auth()->id())->orderBy('id', 'desc')->paginate(getPaginate());
        }

        $emptyMessage = 'No data found';
        return view($this->activeTemplate . '.user.bvLog',compact('pageTitle','emptyMessage','logs'));
    }

    public function myRefLog()
    {
        $pageTitle = "Myeferral";
        $emptyMessage = 'No data found';
        $logs = User::where('ref_id', auth()->id())->latest()->paginate(getPaginate());
        return view($this->activeTemplate . '.user.myRef',compact('pageTitle','emptyMessage','logs'));
    }

    public function myTree()
    {
        $tree = showTreePage(auth()->user()->id);
        $pageTitle = "My Tree";
        return view($this->activeTemplate . 'user.myTree',compact('pageTitle','tree'));
    }


    public function otherTree(Request $request, $username = null)
    {
        if ($request->username) {
            $user = User::where('username', $request->username)->first();
        } else {
            $user = User::where('username', $username)->first();
        }
        if ($user && treeAuth($user->id, auth()->id())) {
            $tree = showTreePage($user->id);
            $pageTitle = "Tree of " . $user->fullname;
            return view($this->activeTemplate . 'user.myTree',compact('pageTitle','tree'));
        }

        $notify[] = ['error', 'Tree Not Found or You do not have Permission to view that!!'];
        return redirect()->route('user.my.tree')->withNotify($notify);

    }
}
