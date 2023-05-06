@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate.'layouts.breadcrumb')

<section class="blog-details padding-top padding-bottom">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-8">
                    <div class="blog-details-wrapper">
                        <div class="details-thumb"><img src="{{ getImage('assets/images/frontend/blog/'.$blog->data_values->blog_image,'820x540') }}" alt="blog"></div>
                        <h3 class="title">{{ __($blog->data_values->title) }}</h3>
                        <p>@php echo $blog->data_values->description @endphp</p>
                    </div>
                    <div class="comments-area">
                        <div class="fb-comments" data-width="100%"
                             data-numposts="5"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        <div class="sidebar-item">
                            <h5 class="title">@lang('Recent Post')</h5>
                            <div class="recent-post-wrapper">
                                @foreach($latestBlogs as $blog)
                                <div class="recent-post-item">
                                    <div class="thumb"><img src="{{ getImage('assets/images/frontend/blog/'.$blog->data_values->blog_image,'820x540') }}" alt="blog"></div>
                                    <div class="content">
                                        <h6 class="title hover-line"><a href="{{ route('blog.details',[slug($blog->data_values->title),$blog->id]) }}">{{ __($blog->data_values->title) }}</a></h6>
                                        <span class="date"><i class="las la-calendar-check"></i>{{$blog->created_at->format('d M, Y')}}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')

    @php echo fbcomment() @endphp
@endpush
