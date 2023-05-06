@extends('admin.layouts.app')

@section('panel')
    <div class="col-lg-12">
        <div class="card">
            <form action="{{ route('admin.setting.notice.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('All user notice')</label>
                                <textarea rows="10" class="form-control nicEdit"  name="notice">{{ __($general->notice) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>@lang('Free user notice')</label>
                                <textarea rows="10" class="form-control nicEdit"  name="free_user_notice">{{ __($general->free_user_notice) }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer py-4">
                    <button type="submit" class="btn btn-block btn--primary mr-2">@lang('Update')</button>
                </div>
            </form>
        </div>
    </div>

@endsection
