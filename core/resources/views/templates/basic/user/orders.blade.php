@extends($activeTemplate.'layouts.master')
@section('content')
<h4 class="mb-2">@lang('Orders')</h4>
<table class="transection-table-2">
    <thead>
        <tr>
            <th>@lang('Product')</th>
            <th>@lang('Quantity')</th>
            <th>@lang('Price')</th>
            <th>@lang('Total Price')</th>
            <th>@lang('Status')</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
            <tr>
                <td data-label="@lang('Product')">{{ __($order->product->name) }}</td>
                <td data-label="@lang('Quantity')">{{ __($order->quantity) }}</td>
                <td data-label="@lang('Price')">{{ showAmount($order->price) }} {{ $general->cur_text }}</td>
                <td data-label="@lang('Total Price')">{{ showAmount($order->total_price) }} {{ $general->cur_text }}</td>
                <td data-label="@lang('Status')">
                    @if($order->status == 0)
                        <span class="badge bg--warning">@lang('Pending')</span>
                    @elseif($order->status == 1)
                        <span class="badge bg--success">@lang('Shipped')</span>
                    @else
                        <span class="badge bg--danger">@lang('Cancelled')</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100%" class="text-center">@lang('No order found')</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $orders->links() }}
@endsection
