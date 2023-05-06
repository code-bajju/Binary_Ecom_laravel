@php
    $faqTitle = getContent('faq.content', true);
    $faqs = getContent('faq.element');
@endphp


<section class="faq-section padding-top padding-bottom">
    <div class="container">
        <div class="section-header">
            <h2 class="title">@lang(@$faqTitle->data_values->heading)</h2>
            <p>@lang(@$faqTitle->data_values->subheading)</p>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="faq-wrapper style-two">
                    @foreach($faqs as $key => $faql)
                        <div class="faq-item">
                            <div class="faq-title">
                                <h6 class="title">{{ __(@$faql->data_values->question) }}</h6>
                                <div class="right-icon"></div>
                            </div>
                            <div class="faq-content">
                                <p>{{ __(@$faql->data_values->answer) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

