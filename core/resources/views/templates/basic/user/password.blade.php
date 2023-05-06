@extends($activeTemplate.'layouts.master')
@section('content')
<div class="card">
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <h5 class="card-title mb-50 border-bottom pb-2">@lang('Change Password')</h5>
            <div class="form-group">
                <label>@lang('Password')</label>
                <input class="form-control form--control form-control form--control-lg" type="password" name="current_password" required minlength="5">
             </div>
            <div class="form-group mt-3 hover-input-popup">
                <label>@lang('New Password')</label>
                <input class="form-control form--control form-control form--control-lg" type="password" name="password" required minlength="5">
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
            <div class="form-group mt-3">
                <label>@lang('Confirm Password')</label>
                <input class="form-control form--control form-control form--control-lg" type="password" name="password_confirmation" required minlength="5">
             </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn--base w-100">@lang('Save Changes')</button>
        </div>
    </form>
</div>
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
