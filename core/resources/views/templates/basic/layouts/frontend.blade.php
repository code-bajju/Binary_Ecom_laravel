<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $general->sitename}} - {{__(@$pageTitle)}} </title>

    <link rel="shortcut icon" href="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}" type="image/x-icon">
    @include('partials.seo')

    {{--  ===============template css==================  --}}
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/global/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/global/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/owl.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/color.php')}}?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}">
    {{--  =============== end template css==================  --}}

    @stack('style-lib')
    @stack('style')

</head>

<body>

    @stack('facebook')

    @include($activeTemplate.'partials.header')
    @yield('content')
    @include($activeTemplate.'partials.footer')


    {{--  ===============template js==================  --}}
    <a href="#0" class="scrollToTop active"><i class="las la-chevron-up"></i></a>
    <script src="{{asset('assets/global/js/jquery-3.6.0.min.js')}}"></script>
    <script src=" {{asset($activeTemplateTrue . 'js/bootstrap.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'js/owl.min.js')}}"></script>
    <script src=" {{asset($activeTemplateTrue . 'js/viewport.jquery.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'js/magnific-popup.min.js')}}"></script>
    <script src=" {{asset($activeTemplateTrue . 'js/isotope.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'js/main.js')}}"></script>
    {{--  ===============end template js==================  --}}

    @stack('script-lib')
    @stack('js')
    @include('partials.notify')
    @include('partials.plugins')

    <script>
        $(".langSel").on("change", function() {
            window.location.href = "{{route('home')}}/change/"+$(this).val() ;
        });
    </script>
    @stack('script')

</body>
</html>
