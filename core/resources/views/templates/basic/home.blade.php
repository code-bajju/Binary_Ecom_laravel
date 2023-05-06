
@extends($activeTemplate.'layouts.frontend')
@php
    $bannerSectionContent=getContent('banner.content',true);
@endphp
@section('content')
@if($bannerSectionContent != null )
    <!-- Banner Section Starts Here -->
    <section class="banner-section bg_img" style="background: url({{ getImage('assets/images/frontend/banner/'.$bannerSectionContent->data_values->image) }}) left center;">
        <span class="bg-shape"></span>
        <div class="container">
            <div class="banner-content">
                <h1 class="title">{{ __(@$bannerSectionContent->data_values->heading) }}</h1>
                <p>{{ __(@$bannerSectionContent->data_values->sub_heading) }}</p>
                <div class="button--wrapper">
                    <a href="{{@$bannerSectionContent->data_values->left_button_link}}" class="cmn--btn active"><span>{{ __(@$bannerSectionContent->data_values->left_button) }}</span></a>
                    <a href="{{@$bannerSectionContent->data_values->right_button_link}}" class="cmn--btn"><span>{{ __(@$bannerSectionContent->data_values->right_button) }}</span></a>
                </div>
            </div>
        </div>
        <div class="shapes d-none d-sm-block">
            <div class="shape shape1">
                <img src="{{asset($activeTemplateTrue.'images/shape/circle-triangle.png')}}" alt="shape">
            </div>
            <div class="shape2 shape">
                <img src="{{asset($activeTemplateTrue.'images/shape/shape-circle.png')}}" alt="shape">
            </div>
            <div class="shape3 shape">
                <img src="{{asset($activeTemplateTrue.'images/shape/dots-colour.png')}}" alt="shape">
            </div>
            <div class="shape4 shape">
                <img src="{{asset($activeTemplateTrue.'images/shape/plus-big.png')}}" alt="shape">
            </div>
            <div class="shape5 shape">
                <img src="{{asset($activeTemplateTrue.'images/shape/waves.png')}}" alt="shape">
            </div>
        </div>
    </section>
    <!-- Banner Section Ends Here -->
 @endif
 @if($sections->secs != null)
 @foreach(json_decode($sections->secs) as $sec)
     @include($activeTemplate.'sections.'.$sec)
 @endforeach
@endif

@endsection



