<div class="overlay"></div>
<!-- Preloader -->
<div id="preloader">
    <div id="loader"></div>
</div>

<!-- Header Section Starts Here -->
<header class="header">
    <div class="header-bottom">
        <div class="container">
            <div class="header-bottom-area">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{asset(imagePath()['logoIcon']['path'].'/logo.png')}}" alt="logo">
                    </a>
                </div> <!-- Logo End -->

                <div class="header-trigger-wrapper d-flex d-lg-none align-items-center">
                    <div class="header-trigger d-block d-lg-none">
                        <span></span>
                    </div>
                    <div class="account-cart-wrapper">
                        <a class="account" href="{{ route('user.login') }}"><i class="las la-user"></i></a>
                    </div>
                </div> <!-- Trigger End-->

                <ul class="menu">
                    <li><a href="{{route('home')}}">@lang('Home')</a></li>
                    <li><a href="{{route('products')}}">@lang('Product')</a></li>

                    @foreach($pages as $k => $data)
                    <li><a href="{{route('pages',[$data->slug])}}">{{trans($data->name)}}</a></li>
                    @endforeach
                    <li><a href="{{route('blog')}}">@lang('Blog')</a></li>
                    <li><a href="{{route('contact')}}">@lang('Contact')</a></li>

                    <li>
                        <select class="langSel">
                            @foreach($language as $item)
                                <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                            @endforeach
                        </select>
                    </li>

                    <li class="account-cart-wrapper d-none d-lg-block">
                        <a class="account" href="{{ route('user.login') }}"><i class="las la-user"></i></a>
                    </li>
                </ul> <!-- Menu End -->
            </div>
        </div>
    </div>
</header>
<!-- Header Section Ends Here -->
