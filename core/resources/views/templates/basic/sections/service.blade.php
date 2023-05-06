@php
$serviceSectionContent = getContent($sec.'.content',true);
$serviceSectionElements = getContent($sec.'.element');

@endphp
@if(@$serviceSectionContent)


<!-- Service Section Starts Here -->
<section class="service-section padding-bottom pos-rel">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="section-header text-center">
                    <span class="subtitle">{{__(@$serviceSectionContent->data_values->heading)}}</span>
                    <h2 class="title">{{__(@$serviceSectionContent->data_values->sub_heading)}}</h2>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">

            @if(@$serviceSectionElements !=null && !empty(@$serviceSectionElements->toArray()))
            @foreach($serviceSectionElements as $serviceSectionElement)
            <div class="col-lg-4 col-md-6 col-sm-10">
                <div class="service-item">
                    <div class="service-icon">@php echo @$serviceSectionElement->data_values->icon @endphp</div>
                    <div class="service-content">
                        <h4 class="title">{{ __(@$serviceSectionElement->data_values->title)}}</h4>
                        <p>{{ __(@$serviceSectionElement->data_values->description) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>
<!-- Service Section Ends Here -->
@endif
