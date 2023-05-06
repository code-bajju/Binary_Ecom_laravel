@extends($activeTemplate.'layouts.frontend')
@section('content')
    @include($activeTemplate.'layouts.breadcrumb')
    <section class="account-section padding-bottom padding-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h6>@lang('Reset Password')</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.password.update') }}">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group hover-input-popup">
                                    <label for="password">@lang('Password')</label>
                                    <input id="password" type="password" class="form-control form--control" name="password" required>
                                    @if($general->secure_password)
                                        <div class="input-popup">
                                            <p class="error lower">@lang('1 small letter minimum')</p>
                                            <p class="error capital">@lang('1 capital letter minimum')</p>
                                            <p class="error number">@lang('1 number minimum')</p>
                                            <p class="error special">@lang('1 special character minimum')</p>
                                            <p class="error minimum">@lang('6 character password')</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">@lang('Confirm Password')</label>
                                    <input id="password-confirm" type="password" class="form-control form--control" name="password_confirmation" required>
                                </div>
                                <div class="form-group">
                                        <button type="submit" class="btn btn--base w-100">
                                            @lang('Reset Password')
                                        </button>
                                    <a href="{{ route('user.login') }}" >@lang('Login Here')</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script-lib')
<script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
        @if($general->secure_password)
            $('input[name=password]').on('input',function(){
                secure_password($(this));
            });
        @endif
    })(jQuery);
</script>
@endpush
