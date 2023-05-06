@extends($activeTemplate.'layouts.master')
@section('content')

    <div class="row design-order-process">
        <div class="col-lg-6 col-sm-12 mb-10">
            <div class="faq-contact">

                @if(Auth::user()->ts == '1')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="panel-title text-center">@lang('Two Factor Authenticator')</h3>
                        </div>
                        <div class="card-body text-center">
                            <button type="button" class="btn btn-block btn-lg bttn btn-fill btn--danger" data-bs-toggle="modal" data-bs-target="#disableModal">@lang('Disable Two Factor Authenticator')</button>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-header">
                            <h4 class="panel-title text-center">@lang('Two Factor Authenticator')</h4>
                        </div>
                        <div class="card-body text-center">
                            <div class="input-group mb-3">
                                <input type="text" name="key" value="{{$secret}}" class="form-control form--control" id="code" readonly>
                                <span class="input-group-text bg--success text-white" id="copybtnpp">@lang('Copy')</span>
                            </div>
                            <div class="form-group">
                                <img src="{{$qrCodeUrl}}">
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn w-100 btn--base" data-bs-toggle="modal" data-bs-target="#enableModal">@lang('Enable Two Factor Authenticator')</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-6 col-sm-12">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="panel-title">@lang('Google Authenticator')</h4>
                </div>
                <div class="card-body text-justify">
                    <h5 class="mb-2">@lang('Use Google Authenticator to Scan the QR code  or use the code')</h5>
                    <p class="font-20">{{__('Google Authenticator is a multi factor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')}}</p>
                </div>

                <div class="card-footer">
                    <a class="btn btn--base w-100" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('DOWNLOAD APP')</a>
                </div>
            </div>
        </div>
    </div>


    @push('modal')
    <div id="enableModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content blue-bg">
                <div class="modal-header">
                    <h4 class="modal-title text-dark">@lang('Verify Your OTP')</h4>
                    <button type="button" class="close text-white" data-bs-dismiss="modal">&times;</button>

                </div>
                <form action="{{route('user.twofactor.enable')}}" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="key" value="{{$secret}}">
                            <input type="text" class="form-control form--control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success pull-right">@lang('Submit')</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
    <!--Disable Modal -->
    <div id="disableModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content blue-bg ">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Verify Your OTP to Disable')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>

                </div>
                <form action="{{route('user.twofactor.disable')}}" method="POST">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control form--control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--success btn-block pull-left">@lang('Verify')</button>
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
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
        document.getElementById("copybtnpp").onclick = function()
        {
            document.getElementById('code').select();
            document.execCommand('copy');
            notify('success', 'Copied successfully');
        }
    </script>
@endpush
