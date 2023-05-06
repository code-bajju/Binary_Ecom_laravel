@php

    $teamSectionContent = getContent($sec.'.content', true);
    $teamSectionElements = getContent($sec.'.element');
@endphp


@if($teamSectionContent !=null )

<!-- Team Section Starts Here -->
<section class="team-section padding-bottom pos-rel">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="section-header text-center">
                    <span class="subtitle">{{__(@$teamSectionContent->data_values->heading)}}</span>
                    <h2 class="title">{{__(@$teamSectionContent->data_values->sub_heading)}}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center gy-4">

            @if(@$teamSectionElements && !empty($teamSectionElements->toArray()))
            @foreach($teamSectionElements as $teamSectionElement)
            <div class="col-lg-4 col-md-6 col-sm-10">
                <div class="team-item">
                    <div class="team-thumb"><img src="{{getImage('assets/images/frontend/team/'.$teamSectionElement->data_values->image,'350x350')}}" alt="testimonials"></div>
                    <div class="team-content">
                        <h4 class="name">{{__(@$teamSectionElement->data_values->name)}}</h4>
                        <span class="designation">{{__(@$teamSectionElement->data_values->designation)}}</span>
                        <ul class="social-icons">
                            <li><a href="{{@$teamSectionElement->data_values->facebook_link}}"><i class="lab la-facebook-f"></i></a></li>
                            <li><a href="{{@$teamSectionElement->data_values->twitter_link}}"><i class="lab la-twitter"></i></a></li>
                            <li><a href="{{@$teamSectionElement->data_values->instagram_link}}"><i class="lab la-instagram"></i></a></li>
                            <li><a href="{{@$teamSectionElement->data_values->vimeo_link}}"><i class="lab la-vimeo"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
            @endif

        </div>
    </div>
</section>
<!-- Team Section Ends Here -->

@endif
