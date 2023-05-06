@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate.'layouts.breadcrumb')

<!-- Products Section Starts Here -->
    <section class="product-section padding-top padding-bottom mb-5">
        <div class="container">
            <ul class="mr-list justify-content-center mb-4">
                <li class="mr-list__item">
                    <a href="{{ route('products') }}" class="mr-list__btn @if(!$categoryId) active @endif">@lang('All Products')</a>
                </li>
                @foreach ($categories as $category)
                <li class="mr-list__item">
                    <a href="{{ route('products',$category->id) }}" class="mr-list__btn @if($categoryId == $category->id) active @endif">{{ __($category->name) }}</a>
                </li>
                @endforeach
            </ul>
            <div class="row g-3">
                @foreach($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                    <div class="product-item">
                        <div class="product-thumb">
                            <img src="{{getImage(imagePath()['products']['path'].'/'.$product->thumbnail,imagePath()['products']['size'])}}" alt="products">
                            <ul class="product-options">
                                <li><a class="image" href="{{getImage(imagePath()['products']['path'].'/'.$product->thumbnail,imagePath()['products']['size'])}}"><i class="las la-expand"></i></a></li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <h6 class="product-title"><a  href="{{ route('product.details',['id' => $product->id, 'slug' => slug($product->name)])}}" >{{ __(shortDescription($product->name,35)) }}</a></h6>

                            @if ($product->quantity>=0)
                            <span class="product-availablity text--success">@lang('in stock')</span>
                            @else
                            <span class="product-availablity text--danger">@lang('out stock')</span>

                            @endif


                            <div class="product-price">
                                <span class="current-price">{{ $general->cur_sym }}{{showAmount($product->price)}}</span>
                            </div>
                            <a href="{{ route('product.details',['id' => $product->id, 'slug' => slug($product->name)])}}" class="add-to-cart cmn--btn-2">@lang('Details')</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {{ $products->links() }}
        </div>
    </section>
    <!-- Products Section Ends Here -->

@if($sections->secs != null)
 @foreach(json_decode($sections->secs) as $sec)
     @include($activeTemplate.'sections.'.$sec)
 @endforeach
@endif
    @endsection
