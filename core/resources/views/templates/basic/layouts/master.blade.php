<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $general->sitename}} - {{__(@$pageTitle)}} </title>

    <link rel="shortcut icon" href="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}" type="image/x-icon">
    @include('partials.seo')


    {{-- =====================template css=====================  --}}
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/global/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/global/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/owl.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/color.php')}}?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}">
    {{-- =====================end template css=====================  --}}

    @stack('style-lib')
    @stack('style')
</head>

<body>
    @include($activeTemplate.'partials.header')
    @include($activeTemplate.'layouts.breadcrumb')

    <section class="user-dashboard padding-top padding-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="dashboard-sidebar">
                        <div class="close-dashboard d-lg-none">
                            <i class="las la-times"></i>
                        </div>
                        <div class="dashboard-user">
                            <div class="user-thumb">
                                <img src="{{ getImage('assets/images/user/profile/'. auth()->user()->image, '350x300')}}" alt="dashboard">
                            </div>
                            <div class="user-content">
                                <span>@lang('Welcome')</span>
                                <h5 class="name">{{ auth()->user()->getFullnameAttribute() }}</h5>
                            </div>
                        </div>
                        <ul class="user-dashboard-tab">
                            <li>
                                <a class="{{menuActive('user.home')}}" href="{{route('user.home')}}">@lang('Dasboard')</a>
                            </li>
                            <li>
                                <a class="{{menuActive('user.plan.index')}}" href="{{route('user.plan.index')}}"> @lang('Plan') </a>
                            </li>
                            <li>
                                <a class="{{menuActive('user.bv.log')}}" href="{{ route('user.bv.log') }}">@lang('BV Log') </a>
                            </li>
                            <li>
                                <a class="{{menuActive('user.my.ref')}}" href="{{ route('user.my.ref') }}"> @lang('My Referrals')</a>
                            </li>
                            <li>
                                <a class="{{menuActive('user.my.tree')}}" href="{{ route('user.my.tree') }}">@lang('My Tree')</a>
                            </li>
                            <li>
                                <a href="{{ route('user.binary.summery') }}" class="{{menuActive('user.binary.summery')}}">
                                    @lang('Binary Summery')
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.orders') }}" class="{{menuActive('user.orders')}}">
                                    @lang('Orders')
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.deposit') }}" class="{{menuActive('user.deposit')}}">
                                    @lang('Deposit Now')
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.withdraw') }}" class="{{menuActive('user.withdraw')}}">
                                    @lang('Withdraw Now')
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.balance.transfer') }}" class="{{menuActive('user.balance.transfer')}}">
                                    @lang('Balance Transfer')
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('ticket') }}" class="{{menuActive('ticket')}}">
                                    @lang('Support Ticket')
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.twofactor') }}" class="{{menuActive('user.twofactor')}}">
                                    @lang('2FA Security')
                                </a>
                            </li>
                            <li>
                                <a class="{{menuActive('user.profile.setting')}}" href="{{route('user.profile.setting')}}" class="">@lang('Profile Setting')</a>
                            </li>
                            <li>
                                <a class="{{menuActive('user.change.password')}}" href="{{route('user.change.password')}}" class="">@lang('Change Password')</a>
                            </li>
                            <li>
                                <a href="{{ route('user.logout') }}" class="">@lang('Sign Out')</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">

                    <div class="user-toggler-wrapper d-flex d-lg-none">
                        <h4 class="title">{{ __($pageTitle) }}</h4>
                        <div class="user-toggler">
                            <i class="las la-sliders-h"></i>
                        </div>
                    </div>


                    @yield('content')
                </div>
            </div>
        </div>
        @stack('modal')
    </section>


    @include($activeTemplate.'partials.footer')


    {{-- =========== template js ===============  --}}
    <a href="#0" class="scrollToTop active"><i class="las la-chevron-up"></i></a>
    <script src="{{asset('assets/global/js/jquery-3.6.0.min.js')}}"></script>
    <script src=" {{asset($activeTemplateTrue . 'js/bootstrap.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'js/owl.min.js')}}"></script>
    <script src=" {{asset($activeTemplateTrue . 'js/nice-select.js')}}"></script>
    <script src=" {{asset($activeTemplateTrue . 'js/viewport.jquery.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'js/magnific-popup.min.js')}}"></script>
    <script src=" {{asset($activeTemplateTrue . 'js/isotope.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'js/main.js')}}"></script>
    {{-- =========== template js ===============  --}}

    @stack('script-lib')
    @stack('script')

    @include('partials.notify')
    @include('partials.plugins')

    <script>
        $(".langSel").on("change", function() {
            window.location.href = "{{route('home')}}/change/"+$(this).val() ;
        });
    </script>


</body>
</html>
