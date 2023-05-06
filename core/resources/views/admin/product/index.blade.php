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
                                <th scope="col">@lang('Thumbnail')</th>
                                <th scope="col">@lang('Price')</th>
                                <th scope="col">@lang('Quantity')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(@$products as $key => $product)
                            <tr>
                                <td data-label="@lang('Sl')">{{ $products->firstItem() + $loop->index }}</td>
                                <td data-label="@lang('Name')">{{ __($product->name) }}</td>
                                <td data-label="@lang('Thumbnail')"> <img src="{{ getImage(imagePath()['products']['path'].'/'.$product->thumbnail,imagePath()['products']['size'])}}" alt="" class="shadow rounded __img"></td>
                                <td data-label="@lang('Price')">{{ __(showAmount($product->price)) }} {{ $general->cur_text }}</td>
                                <td data-label="@lang('Quantity')">{{ __($product->quantity) }}</td>
                                 <td data-label="@lang('Status')">
                                    <div class="__status_switch" data-action="{{ route('admin.product.status.change', $product->id) }}" data-status="{{ $product->status }}" data-id="{{ $product->id }}">
                                    </div>
                                </td>
                                <td data-label="@lang('Action')">
                                    <a  class="icon-btn edit text-white" href="{{ route('admin.product.edit',$product->id) }}" data-toggle="tooltip" data-original-title="Edit">
                                        <i class="la la-pencil"></i>
                                    </a>
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
                {{ @$products->links('admin.partials.paginate') }}
            </div>
        </div>
    </div>
</div>

@endsection



@push('breadcrumb-plugins')
<a href="{{ route('admin.product.create') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-plus"></i>@lang('Add
    New')</a>

@endpush

@push('script')
<script>
    "use strict";
    (function($) {



    })(jQuery);

</script>

<script src="{{ asset('assets/admin/js/status-switch.js') }}"></script>


@endpush

@push('style')
<style>
    .__img {
        max-width: 150px;
        border-radius: 5px;
        padding: 5px;
    }

</style>
@endpush
