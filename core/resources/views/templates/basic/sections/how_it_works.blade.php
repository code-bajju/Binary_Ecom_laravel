@php

$worksSectionContent = getContent($sec.'.content',true);
$worksSectionElements = getContent($sec.'.element');
@endphp
@if(@$worksSectionContent)

<!-- How it Work Section Starts Here -->
<section class="work-section padding-bottom pos-rel">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="section-header text-center">
                    <span class="subtitle">{{__(@$worksSectionContent->data_values->heading)}}</span>
                    <h2 class="title">{{__(@$worksSectionContent->data_values->sub_heading)}}</h2>
                </div>
            </div>
        </div>
        <div class="row gy-5">

            @if(@$worksSectionElements && !empty($worksSectionElements->toArray()))
            @foreach(@$worksSectionElements as $worksSectionElement)
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="work-item">
                    <div class="work-icon">@php echo @$worksSectionElement->data_values->icon @endphp</div>
                    <div class="work-content">
                        <h4 class="title">{{__(@$worksSectionElement->data_values->title)}}</h4>
                        <p>{{__(@$worksSectionElement->data_values->description)}}</p>
                    </div>
                </div>
            </div>
            @endforeach
            @endif


        </div>
    </div>
    <div class="shape shape1"><img src="{{asset($activeTemplateTrue.'images/shape/circle-big.png')}}" alt="shape"></div>
</section>
<!-- How it Work Section Ends Here -->



@endif
