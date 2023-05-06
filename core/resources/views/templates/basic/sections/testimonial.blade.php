
@php
    $testimonialSectionContent = getContent($sec.'.content',true);
    $testimonials = getContent('testimonial.element');
@endphp
 <!-- Testimonial Section Starts Here -->
<section class="testimonial-section padding-bottom pos-rel">
    <div class="container">
        <div class="testimonial-wrapper row">
            <div class="col-lg-6">
                <div class="section-header">
                    <span class="subtitle">{{__(@$testimonialSectionContent->data_values->heading)}}</span>
                    <h2 class="title">{{__(@$testimonialSectionContent->data_values->sub_heading)}}</h2>
                </div>
                <div class="testimonial-slider owl-carousel owl-theme" data-slider-id="1">
                    @foreach($testimonials as $testimonial)
                    <div class="testimonial-item">
                        <div class="quote-icon"><i class="flaticon-left-quote"></i></div>
                        <p>{{ __($testimonial->data_values->quote) }}</p>
                        <div class="thumb"><img src="{{ getImage('assets/images/frontend/testimonial/'.$testimonial->data_values->image) }}" alt="testimonials"></div>
                        <h4 class="name">{{ __($testimonial->data_values->author) }}</h4>
                        <span class="designation">{{ __($testimonial->data_values->designation) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div class="owl-thumbs testimonial-img-slider" data-slider-id="1">
                    @foreach($testimonials as $testimonial)
                    <div class="owl-thumb-item">
                        <div class="thumb thumb{{ $loop->index }}"><img src="{{ getImage('assets/images/frontend/testimonial/'.$testimonial->data_values->image) }}" alt="testimonials"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="shape shape1"><img src="{{asset($activeTemplateTrue.'images/shape/blob.png')}}" alt="shape"></div>
    <div class="shape shape2"><img src="{{asset($activeTemplateTrue.'images/icon/quote.png')}}" alt="icon"></div>
</section>
<!-- Testimonial Section Ends Here -->



