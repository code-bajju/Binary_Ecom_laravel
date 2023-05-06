@extends('admin.layouts.app')

@section('panel')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive--md table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th scope="col">@lang('Sl')</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $key => $category)
                            <tr>
                                <td data-label="@lang('Sl')">{{ $key + 1 }}</td>
                                <td data-label="@lang('Name')">{{ __($category->name) }}</td>
                                <td data-label="@lang('Status')">
                                    <div class="__status_switch" data-action="{{ route('admin.category.status.change', $category->id) }}" data-status="{{ $category->status }}" data-id="{{ $category->id }}">
                                    </div>
                                </td>
                                <td data-label="@lang('Action')">
                                    <button type="button" class="icon-btn edit" data-toggle="tooltip" data-category="{{ json_encode($category->only('id', 'name')) }}" data-original-title="Edit">
                                        <i class="la la-pencil"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            <div class="card-footer py-4">
                {{ $categories->links('admin.partials.paginate') }}
            </div>
        </div>
    </div>
</div>




<div id="modal" class="modal  fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('New Category')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('admin.category.store') }}">
                @csrf
                <div class="modal-body">
                    <input class="form-control plan_id" type="hidden" name="id">
                    <div class="form-group">
                        <label class="font-weight-bold"> @lang('Name') :</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Cancel')</button>
                    <button type="submit" class="btn btn--primary">@lang('Submit')</button>
                </div>
            </form>

        </div>
    </div>
</div>


@endsection



@push('breadcrumb-plugins')
<a href="javascript:void(0)" class="btn btn-sm btn--primary add"><i class="fa fa-fw fa-plus"></i>@lang('Add
    New')</a>

@endpush

@push('script')
<script>
    "use strict";
    (function($) {
        $('.edit').on('click', function() {
            var modal = $('#modal');
            let action = "{{ route('admin.category.update', ':id') }}";
            let category = JSON.parse($(this).attr('data-category'));
            $(modal).find('.modal-title').text("@lang('Edit Category')")
            $(modal).find('button[type=submit]').text("@lang('Update')")
            $(modal).find('input[name=name]').val(category.name)
            $(modal).find('form').attr('action', action.replace(':id', category.id))
            console.log(category.id);
            modal.modal('show');
        });

        $('.add').on('click', function() {
            var modal = $('#modal');
            let action = "{{ route('admin.category.store') }}";
            $(modal).find('form').trigger("reset");
            $(modal).find('form').attr('action', action);
            $(modal).find('.modal-title').text("@lang('New Category')")
            $(modal).find('button[type=submit]').text("@lang('Save')")
            modal.modal('show');
        });
    })(jQuery);

</script>

<script src="{{ asset('assets/admin/js/status-switch.js') }}"></script>


@endpush
