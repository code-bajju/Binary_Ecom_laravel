@extends($activeTemplate.'layouts.master')

@section('content')

<div class="row">
    @if($general->notice != null)
        <div class="col-12 mb-30">
            <div class="card border--light mb-4">
                <div class="card-header">@lang('Notice')</div>
                <div class="card-body">
                    <p class="card-text">@php echo $general->notice; @endphp</p>
                </div>
            </div>
        </div>
    @endif
    @if($general->free_user_notice != null)
        <div class="col-12 mb-30">
            <div class="card border--light mb-2">
                @if($general->notice == null)
                    <div class="card-header">@lang('Notice')</div>   @endif
                <div class="card-body">
                    <p class="card-text"> @php echo $general->free_user_notice; @endphp </p>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="row justify-content-center g-3">
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
        <div class="dashboard-item">
            <div class="dashboard-item-header">
                <div class="header-left">
                    <h6 class="title">@lang('Current Balance')</h6>
                    <h3 class="ammount theme-two">{{$general->cur_sym}}{{getAmount(auth()->user()->balance)}}</h3>
                </div>
                <div class="right-content">
                    <div class="icon"><i class="flaticon-wallet"></i></div>
                </div>
            </div>
            <div class="dashboard-item-body">
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
        <div class="dashboard-item">
            <div class="dashboard-item-header">
                <div class="header-left">
                    <h6 class="title">@lang('Total Deposit')</h6>
                    <h3 class="ammount text--base">{{$general->cur_sym}}{{getAmount($totalDeposit)}}</h3>
                </div>
                <div class="icon"><i class="flaticon-save-money"></i></div>
            </div>
            <div class="dashboard-item-body">
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
        <div class="dashboard-item">
            <div class="dashboard-item-header">
                <div class="header-left">
                    <h6 class="title">@lang('Total Withdraw')</h6>
                    <h3 class="ammount theme-one">${{getAmount($totalWithdraw)}}</h3>
                </div>
                <div class="icon"><i class="flaticon-withdraw"></i></div>
            </div>
            <div class="dashboard-item-body">
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
        <div class="dashboard-item">
            <div class="dashboard-item-header">
                <div class="header-left">
                    <h6 class="title">@lang('Complete Withdraw')</h6>
                    <h3 class="ammount theme-two">${{$completeWithdraw}}</h3>
                </div>
                <div class="right-content">
                    <div class="icon"><i class="flaticon-wallet"></i></div>
                </div>
            </div>
            <div class="dashboard-item-body">
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
        <div class="dashboard-item">
            <div class="dashboard-item-header">
                <div class="header-left">
                    <h6 class="title">@lang('Pending Withdraw')</h6>
                    <h3 class="ammount text--base">${{$pendingWithdraw}}</h3>
                </div>
                <div class="icon"><i class="flaticon-withdrawal"></i></div>
            </div>
            <div class="dashboard-item-body">
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
        <div class="dashboard-item">
            <div class="dashboard-item-header">
                <div class="header-left">
                    <h6 class="title">@lang('Reject Withdraw')</h6>
                    <h3 class="ammount theme-one">${{$rejectWithdraw}}</h3>
                </div>
                <div class="icon"><i class="flaticon-fees"></i></div>
            </div>
            <div class="dashboard-item-body">
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
        <div class="dashboard-item">
            <div class="dashboard-item-header">
                <div class="header-left">
                    <h6 class="title">@lang('Total Invest')</h6>
                    <h3 class="ammount theme-one">${{getAmount(auth()->user()->total_invest)}}</h3>
                </div>
                <div class="icon"><i class="flaticon-tag-1"></i></div>
            </div>
            <div class="dashboard-item-body">
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
        <div class="dashboard-item">
            <div class="dashboard-item-header">
                <div class="header-left">
                    <h6 class="title">@lang('Total Referral Commission')</h6>
                    <h3 class="ammount theme-one">${{getAmount(auth()->user()->total_ref_com)}}</h3>
                </div>
                <div class="icon"><i class="flaticon-clipboards"></i></div>
            </div>
            <div class="dashboard-item-body">
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
        <div class="dashboard-item">
            <div class="dashboard-item-header">
                <div class="header-left">
                    <h6 class="title">@lang('Total Binary Commission')</h6>
                    <h3 class="ammount theme-one">${{getAmount(auth()->user()->total_binary_com)}}</h3>
                </div>
                <div class="icon"><i class="flaticon-money-bag"></i></div>
            </div>
            <div class="dashboard-item-body">
            </div>
        </div>
    </div>
</div>
@endsection




