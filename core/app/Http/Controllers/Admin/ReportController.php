<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BvLog;
use App\Models\EmailLog;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function bvLog(Request $request)
    {

        if ($request->type) {
            if ($request->type == 'leftBV') {
                $pageTitle = "Left BV";
                $logs = BvLog::where('position', 1)->where('trx_type', '+')->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
            } elseif ($request->type == 'rightBV') {
                $pageTitle = "Right BV";
                $logs = BvLog::where('position', 2)->where('trx_type', '+')->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
            }elseif ($request->type == 'cutBV') {
                $pageTitle = "Cut BV";
                $logs = BvLog::where('trx_type', '-')->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
            } else {
                $pageTitle = "All Paid BV";
                $logs = BvLog::where('trx_type', '+')->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
            }
        }else{
            $pageTitle = "BV LOG";
            $logs = BvLog::orderBy('id', 'desc')->paginate(getPaginate());
        }

        $emptyMessage = 'No BV log found';
        return view('admin.reports.bvLog',compact('pageTitle','logs','emptyMessage'));
    }

    public function singleBvLog(Request $request, $id)
    {

        $user = User::findOrFail($id);
        if ($request->type) {
            if ($request->type == 'leftBV') {
                $pageTitle = $user->username . " - Left BV";
                $logs = BvLog::where('user_id', $user->id)->where('position', 1)->where('trx_type', '+')->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
            } elseif ($request->type == 'rightBV') {
                $pageTitle = $user->username . " - Right BV";
                $logs = BvLog::where('user_id', $user->id)->where('position', 2)->where('trx_type', '+')->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
            } elseif ($request->type == 'cutBV') {
                $pageTitle = $user->username . " - All Cut BV";
                $logs = BvLog::where('user_id', $user->id)->where('trx_type', '-')->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
            } else {
                $pageTitle = $user->username . " - All Paid BV";
                $logs = BvLog::where('user_id', $user->id)->where('trx_type', '+')->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
            }
        }else{
            $pageTitle = $user->username . " - All  BV";
            $logs = BvLog::where('user_id', $user->id)->orderBy('id', 'desc')->with('user')->paginate(getPaginate());

        }

        $emptyMessage = 'No data found';
        return view('admin.reports.bvLog',compact('pageTitle','logs','emptyMessage'));
    }



    public function refCom(Request $request)
    {
        if ($request->userID)
        {
            $user = User::findOrFail($request->userID);
            $pageTitle = $user->username . ' - Referral Commission Logs';
            $transactions = Transaction::where('user_id', $user->id)->where('remark', 'referral_commission')->with('user')->latest()->paginate(getPaginate());
        }else {
            $pageTitle = 'Referral Commission Logs';
            $transactions = Transaction::where('remark', 'referral_commission')->with('user')->latest()->paginate(getPaginate());
        }

        $emptyMessage = 'No transactions.';
        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'emptyMessage'));
    }

    public function binary(Request $request)
    {
        if ($request->userID)
        {
            $user = User::findOrFail($request->userID);
            $pageTitle = $user->username . ' - Binary Commission Logs';
            $transactions = Transaction::where('user_id', $user->id)->where('remark', 'binary_commission')->with('user')->latest()->paginate(getPaginate());
        }else {
            $pageTitle = 'Referral Commission Logs';
            $transactions = Transaction::where('remark', 'binary_commission')->with('user')->latest()->paginate(getPaginate());
        }

        $emptyMessage = 'No transactions.';
        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'emptyMessage'));
    }
    public function invest(Request $request)
    {
        if ($request->userID)
        {
            $user = User::findOrFail($request->userID);
            $pageTitle = $user->username . ' - Invest Logs';
            $transactions = Transaction::where('user_id', $user->id)->where('remark', 'purchased_plan')->with('user')->latest()->paginate(getPaginate());
        }else {
            $pageTitle = 'Invest Logs';
            $transactions = Transaction::where('remark', 'purchased_plan')->with('user')->latest()->paginate(getPaginate());
        }

        $emptyMessage = 'No transactions.';
        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'emptyMessage'));
    }


    public function transaction()
    {
        $pageTitle = 'Transaction Logs';
        $transactions = Transaction::with('user')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No transactions.';
        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'emptyMessage'));
    }

    public function transactionSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $pageTitle = 'Transactions Search - ' . $search;
        $emptyMessage = 'No transactions.';

        $transactions = Transaction::with('user')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like',"%$search%");
        })->orWhere('trx', $search)->orderBy('id','desc')->paginate(getPaginate());

        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'emptyMessage','search'));
    }

    public function loginHistory(Request $request)
    {
        if ($request->search) {
            $search = $request->search;
            $pageTitle = 'User Login History Search - ' . $search;
            $emptyMessage = 'No search result found.';
            $login_logs = UserLogin::whereHas('user', function ($query) use ($search) {
                $query->where('username', $search);
            })->orderBy('id','desc')->with('user')->paginate(getPaginate());
            return view('admin.reports.logins', compact('pageTitle', 'emptyMessage', 'search', 'login_logs'));
        }
        $pageTitle = 'User Login History';
        $emptyMessage = 'No users login found.';
        $login_logs = UserLogin::orderBy('id','desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'emptyMessage', 'login_logs'));
    }

    public function loginIpHistory($ip)
    {
        $pageTitle = 'Login By - ' . $ip;
        $login_logs = UserLogin::where('user_ip',$ip)->orderBy('id','desc')->with('user')->paginate(getPaginate());
        $emptyMessage = 'No users login found.';
        return view('admin.reports.logins', compact('pageTitle', 'emptyMessage', 'login_logs','ip'));

    }

    public function emailHistory(){
        $pageTitle = 'Email history';
        $logs = EmailLog::with('user')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No data found';
        return view('admin.reports.email_history', compact('pageTitle', 'emptyMessage','logs'));
    }
}
