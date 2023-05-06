@extends('admin.layouts.app')

@section('panel')

    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Product')</th>
                                <th>@lang('Quantity')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Total Price')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td data-label="@lang('User')">
                                    <span class="font-weight-bold">{{$order->user->fullname}}</span>
                                    <br>
                                    <span class="small">
                                    <a href="{{ route('admin.users.detail', $order->user->id) }}"><span>@</span>{{ $order->user->username }}</a>
                                    </span>
                                </td>
                                <td data-label="@lang('Product')">{{ __($order->product->name) }}</td>
                                <td data-label="@lang('Quantity')">{{ __($order->quantity) }}</td>
                                <td data-label="@lang('Price')">{{ showAmount($order->price) }} {{ $general->cur_text }}</td>
                                <td data-label="@lang('Total Price')">{{ showAmount($order->total_price) }} {{ $general->cur_text }}</td>
                                <td data-label="@lang('Status')">
                                    @if($order->status == 0)
                                    <span class="badge badge--warning">@lang('Pending')</span>
                                    @elseif($order->status == 1)
                                    <span class="badge badge--success">@lang('Shipped')</span>
                                    @else
                                    <span class="badge badge--danger">@lang('Cancelled')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Action')">
                                    <button class="btn btn--primary btn-sm orderBtn" data-action="{{ route('admin.order.status',$order->id) }}" @if($order->status != 0) disabled @endif>@lang('Order Status')</button>
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
                    {{ $orders->links() }}
                </div>
            </div><!-- card end -->
        </div>
    </div>

        <div class="modal fade" id="statusModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">@lang('Update Order Status')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
              </div>
              <form action="" method="post">
                  @csrf
                    <div class="modal-body">
                      <div class="form-group">
                          <label>@lang('Order Status')</label>
                          <select class="form-control" name="status">
                              <option value="1">@lang('Shipped')</option>
                              <option value="2">@lang('Cancel')</option>
                          </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn--dark">@lang('Cancel')</button>
                        <button type="submit" class="btn btn--primary">@lang('Submit')</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
@endsection
@push('script')
<script>
    (function($){
        "use strict";

        $('.orderBtn').click(function(){
            var modal = $('#statusModal');
            modal.find('form').attr('action',$(this).data('action'));
            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush
