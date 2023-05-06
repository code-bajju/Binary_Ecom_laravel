@php
    $breadcrumb = getContent('breadcrumb.content',true);
@endphp
<!-- Inner Banner Section Starts Here -->
<div class="inner-banner bg_img" style="background: url({{ getImage('assets/images/frontend/breadcrumb/'.$breadcrumb->data_values->background_image) }}) center;">
    <div class="container">
        <div class="inner-banner-wrapper">
            <h2 class="title">{{__($pageTitle)}}</h2>
            <ul class="breadcums">
                <li><a href="{{ route('home') }}"><i class="flaticon-home"></i>@lang('Home')</a></li>
                <li>{{__($pageTitle)}}</li>
            </ul>
        </div>
    </div>
</div>
<!-- Inner Banner Section Ends Here -->
