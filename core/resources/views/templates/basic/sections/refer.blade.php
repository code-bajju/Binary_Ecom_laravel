
    @php
    $referSectionContent = getContent($sec.'.content',true);


    @endphp

    @if(@$referSectionContent)
    <!-- Referral Section Starts Here -->
    <section class="referral-section" style="background: url({{getImage('assets/images/frontend/refer//'.@$referSectionContent->data_values->background_image,'1900x1200')}}) center;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="refer-content">

                        <h2 class="title">{{__(@$referSectionContent->data_values->heading)}}</h2>
                        <p>{{__(@$referSectionContent->data_values->description)}}</p>
                        <a href="#0" class="cmn--btn active"><span>Get Started</span></a>
                        <div class="shape shape1"><img src="{{asset($activeTemplateTrue.'images/icon/gft.png')}}" alt="icon"></div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="refer-thumb">
                        <img src="{{getImage('assets/images/frontend/refer/'.@$referSectionContent->data_values->refer_image,'650x580')}}" alt="thumb">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Referral Section Ends Here -->
    @endif
