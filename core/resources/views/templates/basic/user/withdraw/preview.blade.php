@extends($activeTemplate.'layouts.master')

@section('content')

        <div class="row justify-content-center mt-2">
            <div class="col-lg-12">
                <div class="card card-deposit">
                    <h5 class="text-center my-3">@lang('Current Balance') :
                    <strong>{{ getAmount(auth()->user()->balance)}}  {{ $general->cur_text }}</strong></h5>
                    <span class="text-center">
                        @php
                            echo  $withdraw->method->description;
                        @endphp
                    </span>
                    <div class="card-body mt-4">
                        <div class="row">
                            <div class="col-md-5">

                                <ul  class="list-group text-center">
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">@lang('Request Amount') :
                                        {{getAmount($withdraw->amount)  }} {{$general->cur_text }}  </span>
                                    </li>

                                    <li class="list-group-item">
                                        <span class="font-weight-bold">@lang('Withdrawal Charge') :
                                         {{getAmount($withdraw->charge) }} {{$general->cur_text }} </span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">@lang('After Charge') :
                                         {{getAmount($withdraw->after_charge) }} {{$general->cur_text }} </span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">@lang('Conversion Rate') : 1 {{$general->cur_text }} =
                                         {{getAmount($withdraw->rate)  }} {{$withdraw->currency }} </span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">@lang('You Will Get')
                                            {{getAmount($withdraw->final_amount)  }} {{$withdraw->currency }} </span>
                                    </li>
                                </ul>
                                <div class="form-group mt-2">
                                    <label class="font-weight-bold">@lang('Balance Will be') : </label>
                                    <div class="input-group">
                                        <input type="text" value="{{getAmount($withdraw->user->balance - ($withdraw->amount))}}"  class="form-control form--control form-control form--control-lg" placeholder="@lang('Enter Amount')" required readonly>
                                        <span class="input-group-text ">{{ $general->cur_text }} </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <form action="{{route('user.withdraw.submit')}}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    @if($withdraw->method->user_data)
                                    @foreach($withdraw->method->user_data as $k => $v)
                                        @if($v->type == "text")
                                            <div class="form-group">
                                                <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                <input type="text" name="{{$k}}" class="form-control form--control" value="{{old($k)}}" placeholder="{{__($v->field_level)}}" @if($v->validation == "required") required @endif>
                                                @if ($errors->has($k))
                                                    <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                @endif
                                            </div>
                                        @elseif($v->type == "textarea")
                                            <div class="form-group">
                                                <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                <textarea name="{{$k}}"  class="form-control form--control"  placeholder="{{__($v->field_level)}}" rows="3" @if($v->validation == "required") required @endif>{{old($k)}}</textarea>
                                                @if ($errors->has($k))
                                                    <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                @endif
                                            </div>
                                        @elseif($v->type == "file")

                                            <div class="form-group">
                                                <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                    <input class="form-control" type="file" name="{{$k}}" accept="image/*" @if($v->validation == "required") required @endif>
                                                @if ($errors->has($k))
                                                    <br>
                                                    <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                    @endif

                                    <div class="form-group">
                                        <button type="submit" class="btn btn--base w-100">@lang('Confirm')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

@endsection

