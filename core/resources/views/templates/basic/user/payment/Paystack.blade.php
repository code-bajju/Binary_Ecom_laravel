@extends($activeTemplate.'layouts.master')
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
                            <form action="{{ route('ipn.'.$deposit->gateway->alias) }}"
                                method="POST" class="text-center">
                              @csrf
                              <button type="button" class="btn btn--base btn-block" id="btn-confirm">@lang('Pay Now')</button>
                              <script src="//js.paystack.co/v1/inline.js" data-key="{{ $data->key }}"
                                      data-email="{{ $data->email }}" data-amount="{{ round($data->amount) }}"
                                      data-currency="{{ $data->currency }}" data-ref="{{ $data->ref }}"
                                      data-custom-button="btn-confirm">
                              </script>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
