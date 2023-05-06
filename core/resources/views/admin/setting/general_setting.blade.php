@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body setting-card">
                    <form action="" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="  font-weight-bold"> @lang('Site Title') </label>
                                    <input class="form-control form-control-lg" type="text" name="sitename" value="{{$general->sitename}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="  font-weight-bold">@lang('Currency')</label>
                                    <input class="form-control form-control-lg" type="text" name="cur_text" value="{{$general->cur_text}}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label class="  font-weight-bold">@lang('Currency Symbol') </label>
                                    <input class="form-control form-control-lg" type="text" name="cur_sym" value="{{$general->cur_sym}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label class="  font-weight-bold">@lang('Balance Transfer Fixed Charge') </label>
                                    <div class="input-group">
                                        <input class="form-control form-control-lg" type="text" name="bal_trans_fixed_charge" value="{{getAmount($general->bal_trans_fixed_charge)}}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{ $general->cur_text }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label class="  font-weight-bold">@lang('Balance Transfer Fixed Charge') </label>
                                    <div class="input-group">
                                        <input class="form-control form-control-lg" type="text" name="bal_trans_per_charge" value="{{getAmount($general->bal_trans_per_charge)}}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label class="  font-weight-bold"> @lang('Timezone')</label>
                                <select class="select2-basic" name="timezone">
                                    @foreach($timezones as $timezone)
                                    <option value="'{{ @$timezone}}'" @if(config('app.timezone') == $timezone) selected @endif>{{ __($timezone) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="  font-weight-bold"> @lang('Site Base Color')</label>
                                <div class="input-group">
                                <span class="input-group-addon ">
                                    <input type='text' class="form-control form-control-lg colorPicker" value="{{$general->base_color}}"/>
                                </span>
                                    <input type="text" class="form-control form-control-lg colorCode" name="base_color" value="{{ $general->base_color }}"/>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="  font-weight-bold"> @lang('Site Secondary Color')</label>
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <input type='text' class="form-control form-control-lg colorPicker" value="{{$general->secondary_color}}"/>
                                </span>
                                    <input type="text" class="form-control form-control-lg colorCode" name="secondary_color" value="{{ $general->secondary_color }}"/>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="  font-weight-bold">@lang('Force Secure Password')</label>
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" name="secure_password" @if($general->secure_password) checked @endif>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="  font-weight-bold">@lang('Agree policy')</label>
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" name="agree" @if($general->agree) checked @endif>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label class="  font-weight-bold">@lang('User Registration')</label>
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" name="registration" @if($general->registration) checked @endif>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="  font-weight-bold">@lang('Force SSL')</label>
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" name="force_ssl" @if($general->force_ssl) checked @endif>
                            </div>
                            <div class="form-group col-lg-2 col-sm-6 col-md-4">
                                <label class="  font-weight-bold"> @lang('Email Verification')</label>
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="ev" @if($general->ev) checked @endif>
                            </div>
                            <div class="form-group col-lg-2 col-sm-6 col-md-4">
                                <label class="  font-weight-bold">@lang('Email Notification')</label>
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="en" @if($general->en) checked @endif>
                            </div>
                            <div class="form-group col-lg-2 col-sm-6 col-md-4">
                                <label class="  font-weight-bold"> @lang('SMS Verification')</label>
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="sv" @if($general->sv) checked @endif>
                            </div>
                            <div class="form-group col-lg-2 col-sm-6 col-md-4">
                                <label class="  font-weight-bold">@lang('SMS Notification')</label>
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="sn" @if($general->sn) checked @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Update')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-4">

        <div class="col-lg-12 mb-30">
            <div class="card">
                  <div class="card-header ">
                    <h4 class="card-title font-weight-normal">@lang('Matching Bonus')</h4>
                </div>
                <form action="{{route('admin.matching-bonus.update')}}" method="post">
                    <div class="card-body">
                        @csrf
                        <div class="row justify-content-between mb-5">
                            <div class="col-md-4">
                                <div class="input-group custom-height">
                                    <input type="text" class="form-control form-control-lg" value="{{getAmount($general->total_bv)}}"
                                           name="total_bv" id="#" aria-describedby="#" required="">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="#">@lang('BV')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <h2 class="text-center">=</h2>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="input-group custom-height">
                                    <input type="text" class="form-control form-control-lg" name="bv_price"
                                           value="{{getAmount($general->bv_price)}}" aria-describedby="#" required="">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="#">{{$general->cur_text}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="input-group mb-3 custom-height">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@lang('MAX')</span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" value="{{getAmount($general->max_bv)}}"
                                           name="max_bv"
                                           aria-label="Amount (to the nearest dollar)">
                                    <div class="input-group-append">
                                        <span class="input-group-text">@lang('BV')</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <label>@lang('Carry / Flush')</label>
                                <select class="form-control form-control-lg" name="cary_flash" required>
                                    <option value="0">@lang('Carry (Cut Only Paid BV)')</option>
                                    <option value="1">@lang('Flush (Cut Weak Leg Value)')</option>
                                    <option value="2">@lang('Flush (Cut All BV and reset to 0)')</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4 ">
                                <label>@lang('Matching Bonus Time')</label>
                                <select name="matching_bonus_time" class="form-control form-control-lg">
                                    <option value="daily">@lang('Daily')</option>
                                    <option value="weekly">@lang('Weekly')</option>
                                    <option value="monthly">@lang('Monthly')</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4" id="daily_time" style="display:none;">
                                <label>@lang('Daily Time')</label>
                                <select name="daily_time" class="form-control form-control-lg">
                                    <option value="1">@lang('01:00')</option>
                                    <option value="2">@lang('02:00')</option>
                                    <option value="3">@lang('03:00')</option>
                                    <option value="4">@lang('04:00')</option>
                                    <option value="5">@lang('05:00')</option>
                                    <option value="6">@lang('06:00')</option>
                                    <option value="7">@lang('07:00')</option>
                                    <option value="8">@lang('08:00')</option>
                                    <option value="9">@lang('09:00')</option>
                                    <option value="10">@lang('10:00')</option>
                                    <option value="11">@lang('11:00')</option>
                                    <option value="12">@lang('12:00')</option>
                                    <option value="13">@lang('13:00')</option>
                                    <option value="14">@lang('14:00')</option>
                                    <option value="15">@lang('15:00')</option>
                                    <option value="16">@lang('16:00')</option>
                                    <option value="17">@lang('17:00')</option>
                                    <option value="18">@lang('18:00')</option>
                                    <option value="19">@lang('19:00')</option>
                                    <option value="20">@lang('20:00')</option>
                                    <option value="21">@lang('21:00')</option>
                                    <option value="22">@lang('22:00')</option>
                                    <option value="23">@lang('23:00')</option>
                                    <option value="24">@lang('24:00')</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4" id="weekly_time" style="display:none;">
                                <label>@lang('Weekly Time')</label>
                                <select name="weekly_time" class="form-control form-control-lg">
                                    <option value="sat">@lang('Saturday')</option>
                                    <option value="sun">@lang('Sunday')</option>
                                    <option value="mon">@lang('Monday')</option>
                                    <option value="tue">@lang('Tuesday')</option>
                                    <option value="wed">@lang('Wednesday')</option>
                                    <option value="thu">@lang('Thursday')</option>
                                    <option value="fri">@lang('Friday')</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4" id="monthly_time" style="display:none;">
                                <label>@lang('Monthly Time')</label>
                                <select name="monthly_time" class="form-control form-control-lg">
                                    <option value="1">@lang('1st day Month')</option>
                                    <option value="15">@lang('15th day of Month')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group col-md-12 text-center">
                            <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Update')</button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/spectrum.css') }}">
@endpush


@push('style')
    <style>
        .sp-replacer {
            padding: 0;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 5px 0 0 5px;
            border-right: none;
        }

        .sp-preview {
            width: 100px;
            height: 46px;
            border: 0;
        }

        .sp-preview-inner {
            width: 110px;
        }

        .sp-dd {
            display: none;
        }
        .select2-container .select2-selection--single {
            height: 44px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 43px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 43px;
        }
    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.colorPicker').spectrum({
                color: $(this).data('color'),
                change: function (color) {
                    $(this).parent().siblings('.colorCode').val(color.toHexString().replace(/^#?/, ''));
                }
            });

            $('.colorCode').on('input', function () {
                var clr = $(this).val();
                $(this).parents('.input-group').find('.colorPicker').spectrum({
                    color: clr,
                });
            });

            $('.select2-basic').select2({
                dropdownParent: $('.setting-card')
            });

            $('select[name=timezone]').val();

            $("select[name=cary_flash]").val("{{ $general->cary_flash}}");
            $("select[name=matching_bonus_time]").val("{{ $general->matching_bonus_time}}");
            $("select[name=weekly_time]").val("{{ $general->matching_when}}");
            $("select[name=monthly_time]").val("{{ $general->matching_when}}");
            $("select[name=daily_time]").val("{{ $general->matching_when}}");

            $('select[name=matching_bonus_time]').on('change', function () {
                matchingBonus($(this).val());
            });

            matchingBonus($('select[name=matching_bonus_time]').val());

            function matchingBonus(matching_bonus_time) {
                if (matching_bonus_time == 'daily') {
                    document.getElementById('weekly_time').style.display = 'none';
                    document.getElementById('monthly_time').style.display = 'none'
                    document.getElementById('daily_time').style.display = 'block'

                } else if (matching_bonus_time == 'weekly') {
                    document.getElementById('weekly_time').style.display = 'block';
                    document.getElementById('monthly_time').style.display = 'none'
                    document.getElementById('daily_time').style.display = 'none'
                } else if (matching_bonus_time == 'monthly') {
                    document.getElementById('weekly_time').style.display = 'none';
                    document.getElementById('monthly_time').style.display = 'block'
                    document.getElementById('daily_time').style.display = 'none'
                }
            }
        })(jQuery);

    </script>
@endpush
