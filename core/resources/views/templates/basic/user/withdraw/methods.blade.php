@extends($activeTemplate.'layouts.master')
@section('content')
<div class="text-end mb-3">
    <a href="{{ route('user.withdraw.history') }}" class="btn btn--base">@lang('Withdraw Log')</a>
</div>
    <div class="row  mt-2">
        @foreach($withdrawMethod as $data)
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card card-deposit">
                    <h5 class="card-header text-center">{{__($data->name)}}</h5>
                    <div class="card-body card-body-deposit">
                        <img src="{{getImage(imagePath()['withdraw']['method']['path'].'/'. $data->image)}}"
                                class="card-img-top w-100 mb-4" alt="{{__($data->name)}}">
                        <ul  class="list-group text-center font-15">
                            <li class="list-group-item">@lang('Limit')
                                : {{getAmount($data->min_limit)}}
                                - {{getAmount($data->max_limit)}} {{$general->cur_text}}</li>
                            <li class="list-group-item"> @lang('Charge')
                                - {{getAmount($data->fixed_charge)}} {{$general->cur_text}}
                                + {{getAmount($data->percent_charge)}}%
                            </li>
                            <li class="list-group-item">@lang('Processing Time')
                                - {{$data->delay}}</li>
                        </ul>

                    </div>
                    <div class="card-footer">
                        <a href="javascript:void(0)"  data-id="{{$data->id}}"
                            data-resource="{{$data}}"
                            class="btn btn--base w-100 deposit" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            @lang('Withdraw Now')</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    @push('modal')
    <!-- Modal -->
    <div class="modal fade" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title method-name" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('user.withdraw.money')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="currency"  class="edit-currency form-control form--control" value="">
                            <input type="hidden" name="method_code" class="edit-method-code  form-control form--control" value="">
                        </div>
                        <div class="form-group">
                            <label>@lang('Enter Amount'):</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control form--control form-control form--control-lg" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount" placeholder="0.00" required=""  value="{{old('amount')}}">
                                <span class="input-group-text  ">{{__($general->cur_text)}}</span>
                            </div>
                        </div>
                        <p class="text-danger text-center depositLimit"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endpush
@endsection
@push('script')
    <script>
        'use strict';
        (function($){
            $('.deposit').on('click', function () {
                var id = $(this).data('id');
                var result = $(this).data('resource');
                $('.method-name').text(`@lang('Withdraw Via ') ${result.name}`);
                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.id);
            });
        })(jQuery)
    </script>
@endpush

