@extends($activeTemplate .'layouts.frontend')
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
                            <form action="{{route('user.go2fa.verify')}}" method="POST" class="cmn-form mt-30">
                                @csrf

                                <div class="form-group">
                                    <label>@lang('Verification Code')</label>
                                    <input type="text" name="code" id="code" class="form-control form--control">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn--base w-100">@lang('Verify Code') <i class="las la-sign-in-alt"></i></button>
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
