@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form  action="{{route('ticket.store')}}"  method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">@lang('Name')</label>
                                <input type="text" name="name" value="{{@$user->firstname . ' '.@$user->lastname}}" class="form-control form-control-lg" placeholder="@lang('Enter your name')" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">@lang('Email address')</label>
                                <input type="email"  name="email" value="{{@$user->email}}" class="form-control form-control-lg" placeholder="@lang('Enter your email')" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="website">@lang('Subject')</label>
                                <input type="text" name="subject" value="{{old('subject')}}" class="form-control form-control-lg" placeholder="@lang('Subject')" >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="priority">@lang('Priority')</label>
                                <select name="priority" class="form-control form-control-lg">
                                    <option value="3">@lang('High')</option>
                                    <option value="2">@lang('Medium')</option>
                                    <option value="1">@lang('Low')</option>
                                </select>
                            </div>
                            <div class="col-12 form-group">
                                <label for="inputMessage">@lang('Message')</label>
                                <textarea name="message" id="inputMessage" rows="6" class="form-control form-control-lg">{{old('message')}}</textarea>
                            </div>
                        </div>

                        <div class="row form-group ">
                            <div class="col-sm-12 file-upload">
                                <label for="inputAttachments">@lang('Attachments')</label>

                                <input type="file" name="attachments[]" id="inputAttachments" class="form-control mb-2" />

                                <div class="fileUploadsContainer"></div>
                                <p class="ticket-attachments-message text-muted">
                                    @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                </p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="javascript:void(0)" class="btn btn--success add-more-btn">
                                <i class="la la-plus"></i>
                                @lang('Add More')
                            </a>
                            <button type="submit" class="btn btn--success btn-block"><i class="fa fa-paper-plane"></i> @lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        'use strict';
        (function($){
            $(document).on("change", '.custom-file-input' ,function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            var itr = 0;

            $('.add-more-btn').on('click', function(){
                itr++
                $(".fileUploadsContainer").append(`<div class="form-group mb-2">
                                <span for="inputAttachments text-white">@lang('Attachments')</span>
                                <input name="attachments[]" type="file" id="customFile" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                            </div>`);

            });

        })(jQuery)
    </script>
@endpush
@push('breadcrumb-plugins')
    <a href="{{route('ticket') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-backward"></i> @lang('Go Back')</a>
@endpush
