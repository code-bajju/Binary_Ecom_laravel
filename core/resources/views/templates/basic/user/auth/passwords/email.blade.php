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
                            <form method="POST" action="{{ route('user.password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <label>@lang('Select One')</label>
                                    <select class="form-control form--control" name="type">
                                        <option value="email">@lang('E-Mail Address')</option>
                                        <option value="username">@lang('Username')</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="my_value"></label>
                                    <input type="text" class="form-control form--control" name="value" value="{{ old('value') }}" required autofocus="off">
                                </div>
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')
<script type="text/javascript">
    $('select[name=type]').change(function(){
        $('.my_value').text($('select[name=type] :selected').text());
    }).change();
</script>
@endpush
