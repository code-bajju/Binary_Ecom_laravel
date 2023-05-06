<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $pageTitle = 'Orders';
        $orders = Order::with('product','user')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'Order not found';
        return view('admin.orders',compact('pageTitle','orders','emptyMessage'));
    }

    public function status(Request $request,$id){
        $request->validate([
            'status'=>'required|in:1,2'
        ]);

        $order = Order::where('status',0)->findOrFail($id);
        $product = $order->product;
        $user = $order->user;

        if($request->status == 1){
            $order->status = 1;
            $details = $product->name.' product purchase';
            updateBV($user->id, $product->bv, $details);
            $template = 'order_shipped';
        }else{
            $order->status = 2;
            $user->balance += $order->total_price;
            $user->save();

            $transaction = new Transaction();
            $transaction->user_id = $order->user_id;
            $transaction->amount = $order->total_price;
            $transaction->post_balance = $user->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = $product->name.' Order cancel';
            $transaction->trx =  $order->trx;
            $transaction->save();

            $product->quantity += $order->quantity;
            $product->save();

            $template = 'order_cancelled';

        }

        $order->save();

        $general = GeneralSetting::first();

        notify($user,$template,[
            'product_name'=>$product->name,
            'quantity'=>$request->quantity,
            'price'=>showAmount($product->price),
            'total_price'=>showAmount($order->total_price),
            'currency'=>$general->cur_text,
            'trx'=>$order->trx,
        ]);

        $notify[] = ['success','Product status updated successfully'];
        return back()->withNotify($notify);

    }
}
