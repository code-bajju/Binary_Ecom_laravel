@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate.'layouts.breadcrumb')


<!-- Blog Section Starts Here -->
<section class="blog-section padding-bottom padding-top">
    <div class="container">
        <div class="row justify-content-center gy-4">
            @foreach($blogs as $blog)
            <div class="col-lg-4 col-md-6 col-sm-10">
                <div class="post-item">
                    <div class="post-thumb"><img src="{{ getImage('assets/images/frontend/blog/thumb_'.$blog->data_values->blog_image) }}" alt="blog">
                        <div class="meta-date">
                            <span class="date">{{ $blog->created_at->format('d M') }}</span>
                            <span>{{ $blog->created_at->format('Y') }}</span>
                        </div>
                    </div>
                    <div class="post-content">
                        <h4 class="title"><a href="{{ route('blog.details',[slug($blog->data_values->title),$blog->id]) }}">{{ __($blog->data_values->title) }}</a></h4>
                        <p>@php echo shortDescription(strip_tags($blog->data_values->description),120) @endphp</p>
                        <a href="{{ route('blog.details',[slug($blog->data_values->title),$blog->id]) }}" class="read-more">@lang('Read More')</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $blogs->links() }}
    </div>
    <div class="shape shape1">
        <img src="{{asset($activeTemplateTrue.'images/shape/blob1.png')}}" alt="shap">
    </div>
</section>
<!-- Blog Section Ends Here -->


@endsection