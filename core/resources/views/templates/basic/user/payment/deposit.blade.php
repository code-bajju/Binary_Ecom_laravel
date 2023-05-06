@extends($activeTemplate.'layouts.master')

@section('content')
    <div class="text-end mb-3">
        <a href="{{ route('user.deposit.history') }}" class="btn btn--base">@lang('Deposit Log')</a>
    </div>
    <div class="row">
        @foreach($gatewayCurrency as $data)
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card card-deposit">
                    <h5 class="card-header text-center">{{__($data->name)}}
                    </h5>
                    <div class="card-body card-body-deposit">
                        <img src="{{$data->methodImage()}}" class="card-img-top depo" alt="{{__($data->name)}}">
                    </div>
                    <div class="card-footer">
                        <a href="javascript:void(0)"  data-id="{{$data->id}}" data-resource="{{$data}}"
                            data-min_amount="{{getAmount($data->min_amount)}}"
                            data-max_amount="{{getAmount($data->max_amount)}}"
                            data-base_symbol="{{$data->baseSymbol()}}"
                            data-fix_charge="{{getAmount($data->fixed_charge)}}"
                            data-percent_charge="{{getAmount($data->percent_charge)}}" class="btn btn--base w-100 deposit" data-bs-toggle="modal" data-bs-target="#depositModal">
                            @lang('Deposit Now')</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


@endsection

@push('modal')
<div class="modal fade" id="depositModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <strong class="modal-title method-name"></strong>
                <a href="javascript:void(0)" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <form action="{{route('user.deposit.insert')}}" method="post">
                @csrf
                <div class="modal-body">
                    <p class="text-danger depositLimit"></p>
                    <p class="text-danger depositCharge"></p>
                    <div class="form-group">
                        <input type="hidden" name="currency" class="edit-currency" value="">
                        <input type="hidden" name="method_code" class="edit-method-code" value="">
                    </div>
                    <div class="form-group">
                        <label>@lang('Enter Amount'):</label>
                        <div class="input-group">
                            <input id="amount" type="text" class="form-control form--control form-control form--control-lg" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount" placeholder="0.00" required  value="{{old('amount')}}">
                            <span class="input-group-text  addon">{{$general->cur_text}}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--base btn-block">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('script')
    <script>
        "use strict";
        (function ($) {
            $('.deposit').on('click', function () {
                var id = $(this).data('id');
                var result = $(this).data('resource');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var baseSymbol = "{{ $general->cur_text }}";
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var depositLimit = `@lang('Deposit Limit:') ${minAmount} - ${maxAmount}  ${baseSymbol}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge = `@lang('Charge:') ${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' +percentCharge + ' % ' : ''}`;
                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Payment By ') ${result.name}`);
                console.log(result.currency);
                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.method_code);
            });
        })(jQuery);
    </script>
@endpush
