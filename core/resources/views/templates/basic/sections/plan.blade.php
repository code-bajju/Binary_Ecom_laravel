@php

    $planeSectionContent = getContent($sec.'.content', true);
    $plans = \App\Models\Plan::where('status', 1)->get();



@endphp



<!-- Pricing Plan Section Starts Here -->
<section class="plan-section padding-bottom pos-rel">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="section-header text-center">
                    <span class="subtitle">{{__(@$planeSectionContent->data_values->heading)}}</span>
                    <h2 class="title">{{__(@$planeSectionContent->data_values->sub_heading)}}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center gy-4">

            @foreach (@$plans as $k=> $plan)
             <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10">
                <div class="plan-item">
                    <span class="plan-serial">{{ $k+1 }}</span>
                    <div class="plan-bottom">
                        <div class="plan-header"><div class="plan-price"><sup>{{$general->cur_sym}}</sup>{{getAmount($plan->price)}}</div></div>
                        <div class="plan-body">
                            <p class="plan-name">{{ __(@$plan->name) }}</p>
                            <ul class="plan-info">
                                <li class="active"><i  class="las la-business-time __plan_info " data="bv"></i>@lang('Business Volume: '){{ __(@$plan->bv) }}</li>
                                <li class="active"><i class="las la-comment-dollar __plan_info" data="ref_com"></i>@lang('Referral Commission: '){{$general->cur_sym}} {{getAmount($plan->ref_com)}}</li>
                                <li class="active"><i class="las la-comments-dollar __plan_info" data="tree_com"></i>@lang('Commission To Tree:') {{$general->cur_sym}} {{getAmount($plan->tree_com)}}</li>

                            </ul>
                            <div class="text-center"><a href="{{route('user.plan.index')}}"  class="cmn--btn-2 btn--md active"><span>@lang('Subscribe Plan')</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<div class="modal fade" id="__modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="__modal_title">@lang('Commission to tree info')</h5>

            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer text-right ">
               <div class="row">
                   <div class="col-lg-12">
                    <button type="button" class="btn btn-danger" id="__modal_close">@lang('Close')</button>
                   </div>
               </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        'use strict';
        (function($){
            $('.__plan_info').on('click', function (e) {
                let html="";
               let data=$(this).attr('data');
               let modal=$("#__modal");
               if(data=='bv'){
                html=` <h5>   <span class="text-danger">@lang('When someone from your below tree subscribe this plan, You will get this Business Volume  which will be used for matching bonus').</span>
                </h5>`
                modal.find('#__modal_title').html("@lang('Business Volume (BV) info')")

               }
               if(data=='ref_com'){
                 html=`  <h5>  <span class=" text-danger">@lang('When Your Direct-Referred/Sponsored  User Subscribe in') <b> @lang('ANY PLAN') </b>, @lang('You will get this amount').</span>
                        <br>
                        <br>
                        <span class="text-success"> @lang('This is the reason You should Choose a Plan With Bigger Referral Commission').</span> </h5>`
                        modal.find('#__modal_title').html("@lang('Referral Commission info')")

               }
               if(data=='tree_com'){
                    html=` <h5 class=" text-danger">@lang('When someone from your below tree subscribe this plan, You will get this amount as Tree Commission'). </h5>`
                    modal.find('#__modal_title').html(html)
                }
              modal.find('.modal-body').html(html)
               $(modal).modal('show')
             });

            $('body').on('click', '#__modal_close',function (e) {
            $("#__modal").modal('hide');
            });
        })(jQuery)
    </script>
@endpush

