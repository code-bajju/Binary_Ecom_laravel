@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate.'layouts.breadcrumb')


<section class="contact-section padding-top padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="contact-thumb rtl">
                    <img src="{{ getImage('assets/images/frontend/contact_us/'.$contact->data_values->image,'700x600') }}" alt="thumb">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="contact-form-wrapper">
                    <h3 class="title">{{ __($contact->data_values->title) }}</h3>
                    <form action="" method="post" class="contact-form">
                        @csrf
                        <div class="form--group">
                            <label for="name" class="form--label">@lang('Name')</label>
                            <input id="name" type="text" name="name" class="form--control" placeholder="@lang('Enter Your Full Name')" required="">
                        </div>
                        <div class="form--group">
                            <label for="email" class="form--label">@lang('Email Address')</label>
                            <input id="email" type="email" name="email" class="form--control" placeholder="@lang('Enter Your Email Address')" required="">
                        </div>
                        <div class="form--group">
                            <label for="subject" class="form--label">@lang('Subject')</label>
                            <input id="subject" type="text" name="subject" class="form--control" placeholder="@lang('Enter Your Subject')" required="">
                        </div>
                        <div class="form--group">
                            <label for="msg" class="form--label">@lang('Your Message')</label>
                            <textarea id="msg" class="form--control pt-3" name="message" placeholder="@lang('Enter Your Message')" required=""></textarea>
                        </div>
                        <div class="form--group">
                            <button type="submit" class="btn btn--base w-100">@lang('Send Us Message')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="contact-info padding-bottom">
    <div class="shape shape1"><img src="{{asset($activeTemplateTrue.'images/shape/all-shape.png')}}" alt="shape"></div>
    <div class="container">
        <div class="row gy-5 justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <div class="contact-info-wrapper row gy-4 justify-content-center">
                    @foreach($informations as $information)
                    <div class="col-lg-12 col-md-6 col-sm-10">
                        <div class="contact-info-item">
                            <div class="thumb"><img src="{{ getImage('assets/images/frontend/contact_us/'.$information->data_values->image) }}" alt="icon"></div>
                            <div class="content">
                                <h5 class="title">{{ __($information->data_values->title) }} :</h5>
                                <span>{{ __($information->data_values->content) }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6 col-xl-7">
                <div class="map-wrapper">
                    <iframe class="map" src="{{ __($contact->data_values->map_iframe_url) }}" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
