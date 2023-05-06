@php
    if (isset($seoContent)) {
        $description = $seoContent->description;
        $keywords = $seoContent->keywords;
        $image = $seoContent->image;
        $socialImageSize = $seoContent->social_image_size;
        $title = $seoContent->title;
    }else{
        $description = $seo->description;
        $keywords = implode(',',$seo->keywords);
        $image = getImage(imagePath()['seo']['path'] .'/'. $seo->image);
        $socialImageSize = explode('x', imagePath()['seo']['size']);
        $title = $general->sitename(__($pageTitle));
    }
@endphp

@if($seo)
    <meta name="title" Content="{{ $title }}">
    <meta name="description" content="{{ $description }}">
    <meta name="keywords" content="{{ $keywords }}">
    <link rel="shortcut icon" href="{{ getImage(imagePath()['logoIcon']['path'] .'/favicon.png') }}" type="image/x-icon">

    {{--<!-- Apple Stuff -->--}}
    <link rel="apple-touch-icon" href="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="{{ $general->sitename($pageTitle) }}">
    {{--<!-- Google / Search Engine Tags -->--}}
    <meta itemprop="name" content="{{ $general->sitename($pageTitle) }}">
    <meta itemprop="description" content="{{ $description }}">
    <meta itemprop="image" content="{{ $image }}">
    {{--<!-- Facebook Meta Tags -->--}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $general->sitename(__($pageTitle)) }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ $image }}"/>
    <meta property="og:image:type" content="image/{{ pathinfo(getImage(imagePath()['seo']['path']) .'/'. $seo->image)['extension'] }}" />
    <meta property="og:image:width" content="{{ $socialImageSize[0] }}" />
    <meta property="og:image:height" content="{{ $socialImageSize[1] }}" />
    <meta property="og:url" content="{{ url()->current() }}">
    {{--<!-- Twitter Meta Tags -->--}}
    <meta name="twitter:card" content="summary_large_image">
@endif
