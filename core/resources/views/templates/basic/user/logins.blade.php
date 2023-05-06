@extends($activeTemplate.'layouts.master')

@section('content')

<table class="transection-table-2">
    <thead>
    <tr>
        <th scope="col">@lang('Date')</th>
        <th scope="col">@lang('IP')</th>
        <th scope="col">@lang('Location')</th>
        <th scope="col">@lang('Browser')</th>
        <th scope="col">@lang('OS')</th>
    </tr>
    </thead>
    <tbody>
    @forelse($login_logs as $log)
        <tr>
            <td data-label="@lang('Date')">{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</td>
            <td data-label="@lang('IP')">{{ $log->user_ip }}</td>
            <td data-label="@lang('Location')">{{ $log->location }}</td>
            <td data-label="@lang('Browser')">{{ $log->browser }}</td>
            <td data-label="@lang('OS')">{{ $log->os }}</td>
        </tr>
    @empty
        <tr>
            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
        </tr>
    @endforelse

    </tbody>

</table>
{{ getPaginate($login_logs) }}
@endsection


