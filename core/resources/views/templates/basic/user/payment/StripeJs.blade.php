@extends($activeTemplate.'layouts.master')
@push('style')
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        .card button {
            padding-left: 0px !important;
        }
    </style>
@endpush

@section('content')
    <div class="row mb-none-30 justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center text-center">
                        <div class="col-md-4">
                            <img src="{{$deposit->gatewayCurrency()->methodImage()}}" class="card-img-top" alt="@lang('Image')" class="w-100">
                        </div>
                        <div class="col-md-8">
                            <h3>@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</h3>
                            <h3 class="my-3">@lang('To Get') {{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</h3>
                            <form action="{{$data->url}}" method="{{$data->method}}">

                                <script src="{{$data->src}}" class="stripe-button"
                                    @foreach($data->val as $key=> $value)
                                    data-{{$key}}="{{$value}}"
                                    @endforeach>
                                </script>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
