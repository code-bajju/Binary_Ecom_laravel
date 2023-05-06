@extends($activeTemplate.'layouts.master')

@section('content')
<div class="text-end mb-3">
    <a href="{{ route('ticket.open') }}" class="btn btn--base">@lang('Create Ticket')</a>
</div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive--sm">
                        <table class="transection-table-2">
                            <thead>
                            <tr>
                                <th scope="col">@lang('SL')</th>
                                <th scope="col">@lang('Subject')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Last Reply')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($supports as $key => $support)
                                <tr>
                                    <td data-label="@lang('SL')">{{$key+1}}</td>
                                    <td data-label="@lang('Subject')"> <a href="{{ route('ticket.view', $support->ticket) }}" class="font-weight-bold"> [@lang('Ticket')#{{ $support->ticket }}] {{ $support->subject }} </a></td>
                                    <td data-label="@lang('Status')">
                                        @if($support->status == 0)
                                            <span class="badge badge--success">@lang('Open')</span>
                                        @elseif($support->status == 1)
                                            <span class="badge badge--primary ">@lang('Answered')</span>
                                        @elseif($support->status == 2)
                                            <span class="badge badge--warning">@lang('Reply')</span>
                                        @elseif($support->status == 3)
                                            <span class="badge badge--dark">@lang('Closed')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('ticket.view', $support->ticket) }}" class="btn btn--base" data-toggle="tooltip" title="" data-original-title="@lang('Details')">
                                            <i class="las la-desktop text--shadow"></i>
                                        </a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">@lang('No ticket found')</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{$supports->links()}}
        </div>
    </div>

@endsection


@push('breadcrumb-plugins')
    <a href="{{route('ticket.open') }}" class="btn btn-sm btn--success box--shadow1 text--small"><i class="las la-plus-circle"></i>@lang('New Ticket')</a>
@endpush

@push('script')
@endpush
