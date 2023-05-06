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
                            <form action="{{route('user.verify.email')}}" method="POST" class="cmn-form mt-30">
                                @csrf

                                <div class="form-group">
                                    <label>@lang('Verification Code')</label>
                                    <input type="text" name="email_verified_code" id="code" class="form-control form--control">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn--base w-100">@lang('Verify Code') <i class="las la-sign-in-alt"></i></button>
                                </div>

                                <div class="form-group d-flex justify-content-between align-items-center">
                                    <p>@lang('Please check including your Junk/Spam Folder. if not found, you can') <a href="{{route('user.send.verify.code')}}?type=email" class="forget-pass"> @lang('Resend code')</a></p>
                                        @if ($errors->has('resend'))
                                            <br/>
                                            <small class="text-danger">{{ $errors->first('resend') }}</small>
                                        @endif
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@push('script')
<script>
    (function($){
        "use strict";
        $('#code').on('input change', function () {
          var xx = document.getElementById('code').value;
          $(this).val(function (index, value) {
             value = value.substr(0,7);
              return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
          });
      });
    })(jQuery)
</script>
@endpush

