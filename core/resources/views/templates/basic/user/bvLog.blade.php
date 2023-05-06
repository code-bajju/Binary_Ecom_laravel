@extends($activeTemplate.'layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 overflow-hidden border-0">
                <div class="card-body p-0">
                    <div class="table-responsive--sm">
                        <table class="transection-table-2">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Sl')</th>
                                <th scope="col">@lang('BV')</th>
                                <th scope="col">@lang('Position')</th>
                                <th scope="col">@lang('Detail')</th>
                                <th scope="col">@lang('Date')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($logs as $key=>$data)
                                <tr><td data-label="@lang('Sl')">{{$logs->firstItem()+$key}}</td>
                                    <td data-label="@lang('BV')" class="budget">
                                        <strong @if($data->trx_type == '+') class="text-success" @else class="text-danger" @endif> {{($data->trx_type == '+') ? '+':'-'}} {{getAmount($data->amount)}}</strong>
                                    </td>

                                    <td data-label="@lang('Position')">
                                        @if ($data->position == 1)<span class="badge badge--success">@lang('Left')</span>
                                        @else
                                            <span class="badge badge--primary">@lang('Right')</span>
                                        @endif</td>
                                    <td data-label="@lang('Detail')">{{$data->details}}</td>
                                    <td data-label="@lang('Date')">{{$data->created_at != ''? date('d/m/y  g:i A',strtotime($data->created_at)): __('Not Assign')}}</td>
                                </tr>

                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4 mt-2 bg-transparent border-0">
                   {{ getPaginate($logs) }}

                </div>
            </div>
        </div>
    </div>

@endsection
