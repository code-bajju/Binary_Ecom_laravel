<!-- ============Footer Section Starts Here============ -->
@stack('modal')
@php
    $socials = getContent('social_icon.element');
    $footer = getContent('footer_section.content',true);
    $policies = getContent('policy_pages.element',false,null,true);
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
@endphp

@if(@$cookie->data_values->status && !session('cookie_accepted'))
<section class="cookie-policy">
    <div class="container">
        <div class="cookie-wrapper">
            <div class="cookie-cont">
                <span>
                    @php echo @$cookie->data_values->description @endphp
                </span>
                <a href="{{ @$cookie->data_values->link }}" class="text--base">@lang('Read more about cookies')</a>
            </div>
            <button class="cmn--btn btn--sm cookie-close policy" style="padding: 9px 17px !important;">@lang('Accept Policy')</button>
        </div>
    </div>
</section>
@endif

<!-- Footer Section Starts Here -->
<footer class="footer-section">
    <div class="footer-top">
        <div class="container">
            <div class="row justify-content-between gy-5">
                <div class="col-lg-4 col-xl-3 col-sm-6">
                    <div class="footer-widget p-0">
                        <div class="logo"><a href="{{ route('home') }}"><img src="{{asset(imagePath()['logoIcon']['path'].'/logo.png')}}" alt="logo"></a></div>
                        <p>{{ __($footer->data_values->description) }}</p>
                    </div>
                </div>
                <div class="col-lg-2 col-xl-3 col-sm-6">
                    <div class="footer-widget">
                        <h4 class="widget-title">@lang('Pages')</h4>
                        <ul class="footer-links">
                            <li><a href="{{ route('home') }}"><i class="las la-angle-double-right"></i>@lang('Home')</a></li>
                            <li><a href="{{ route('products') }}"><i class="las la-angle-double-right"></i>@lang('Products')</a></li>
                            <li><a href="{{route('blog')}}"><i class="las la-angle-double-right"></i>@lang('Blog')</a></li>
                            <li><a href="{{route('contact')}}"><i class="las la-angle-double-right"></i>@lang('Contact')</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-xl-3 col-sm-6">
                    <div class="footer-widget">
                        <h4 class="widget-title">@lang('Userful Links')</h4>
                        <ul class="footer-links">
                            @foreach($policies as $policy)
                            <li><a href="{{ route('policy',[$policy->data_values->title,$policy->id]) }}"><i class="las la-angle-double-right"></i>{{ __($policy->data_values->title) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-xl-3 col-sm-6">
                    <div class="footer-widget">
                        <h4 class="widget-title">@lang('Contact')</h4>
                        <ul class="footer-info">
                            <li><p><i class="las la-map-marker"></i>{{ @$footer->data_values->website_footer_address }}</p></li>
                            <li><a href="tel:{{@$footer->data_values->website_footer_phone_number}}"><i class="las la-phone-volume"></i>{{@$footer->data_values->website_footer_phone_number}}</a></li>
                            <li><a href="mailto:{{ @$footer->data_values->website_footer_email }}"><i class="las la-at"></i>{{ @$footer->data_values->website_footer_email }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-wrapper">
                <p class="copy-text">{{ @$footer->data_values->copyright }}</p>
                <ul class="social-icons">
                    @foreach($socials as $social)
                    <li>
                        <a href="{{@$social->data_values->url}}" target="_blank" title="{{@$social->data_values->title}}">
                            @php echo @$social->data_values->social_icon; @endphp
                        </a>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section Ends Here -->
@push('script')
<script>
    (function($){
        "use strict"
        $('.cookie-close').on('click', function(){
            $('.cookie-policy').slideUp(300)
        })

        $('.policy').on('click',function(){
            $.get('{{route('cookie.accept')}}', function(response){
                $('.cookie-policy').addClass('d-none');
            });
        });

    })(jQuery);
</script>
@endpush
