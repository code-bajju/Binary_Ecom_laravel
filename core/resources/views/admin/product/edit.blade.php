@extends('admin.layouts.app')
@section('panel')
<form action="{{ route('admin.product.update',@$product->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mb-5">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header font-weight-bold  bg--primary">@lang('Product Basic Information')</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="name" class="font-weight-bold">@lang('Product Name') <strong class="text-danger">*</strong> </label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name" id="name" value="{{ @$product->name}}" placeholder="@lang('Name')">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="" class="font-weight-bold">@lang('Categories') <strong class="text-danger">*</strong> </label>
                        </div>
                        <div class="col-md-10">
                            <select class="form-control" name="category">
                                <option disabled>@lang('Please Select One')</option>
                                @foreach (@$categories as $category)
                                <option value="{{ $category->id}}" @if($category->id == $product->category_id) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="" class="font-weight-bold">@lang('Price') <strong class="text-danger">*</strong> </label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" class="form-control" value="{{ getAmount($product->price) }}" name="price" placeholder="@lang('Price')">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="" class="font-weight-bold">@lang('Quantity')</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" class="form-control" value="{{ @$product->quantity }}" name="quantity" placeholder="@lang('Quantity')">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="" class="font-weight-bold">@lang('BV')</label>
                        </div>
                        <div class="col-md-10">
                            <input type="number" class="form-control" value="{{ $product->bv }}" name="bv" placeholder="@lang('BV')">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="" class="font-weight-bold">@lang('Featured')</label>
                        </div>
                        <div class="col-md-10">
                            <select class="form-control" name="featured" required>
                                <option value="1">@lang('Yes')</option>
                                <option value="0">@lang('No')</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-12 mt-5">
            <div class="card">
                <div class="card-header font-weight-bold  bg--primary">@lang('Product Description')</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label class="font-weight-bold">@lang('Product Discription') <strong class="text-danger">*</strong> </label>
                        </div>
                        <div class="col-md-10">
                            <textarea id="my-textarea" class="form-control nicEdit" name="description" rows="3">{{ @$product->description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="" class="font-weight-bold">@lang('Product Specifications')</label>
                        </div>
                        <div class="col-md-10" id="specification">

                            @if(@$product->specifications !=null && !empty(@$product->specifications) )
                            @foreach (@$product->specifications as $k=> $specification)
                            <div class="row mb-2 specification">
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" name="specification[{{ $k }}][name]" value="{{ @$specification['name'] }}" placeholder="@lang('Enter Specification Name')">
                                </div>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" name="specification[{{ $k }}][value]" value="{{ @$specification['value'] }}" placeholder="@lang('Enter Specification Value')">
                                </div>
                                <div class="col-lg-2 text-right minus-specification">
                                    <a class="btn btn-outline--danger "><i class="la la-minus"></i></a>
                                </div>
                            </div>
                            @endforeach
                            <div class="row">
                                <div class="col-lg-10"><label for="" id="specifications-title">@lang('Add specifications as you want by clicking the (+) button on the right side')</label></div>
                                <div class="col-lg-2 text-right">
                                    <a class="btn btn-outline--success add-specification"><i class="la la-plus"></i></a>
                                </div>
                            </div>
                            @else
                            <div class="row">
                                <div class="col-lg-10"><label for="" id="specifications-title">@lang('Add specifications as you want by clicking the (+) button on the right side')</label></div>
                                <div class="col-lg-2 text-right">
                                    <a class="btn btn-outline--success add-specification"><i class="la la-plus"></i></a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mt-5">
            <div class="card">
                <div class="card-header font-weight-bold  bg--primary">@lang('Product Image')</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="" class="font-weight-bold">@lang('Thumbnail') <strong class="text-danger">*</strong></label>
                        </div>
                        <div class="col-md-10">
                            <div class="d-flex">
                                <div class="payment-method-item">
                                    <div class="payment-method-header d-flex flex-wrap">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{getImage(imagePath()['products']['path'].'/'.$product->thumbnail,'450x500')}})"></div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" name="thumbnail" class="profilePicUpload" id="image" accept=".png, .jpg, .jpeg">
                                                <label for="image" class="bg--primary"><i class="la la-pencil"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group row">


                        <div class="col-md-2">
                            <label for="" class="font-weight-bold">@lang('Gallery')</label>
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <a class="btn btn-outline--success add-gallery-image"><i class="la la-plus"></i></a>
                                </div>
                            </div>
                            <div class="row" id="__gallery_image">
                                @if ($product->images  && !empty($product->images ))
                                @php
                                    $imageKey=0;
                                @endphp
                                @foreach ($product->images as $imageKey=> $image)
                                <div class="col-lg-3 __gallery_image">
                                    <div class="form-group">
                                        <a href="{{ route('admin.product.image.remove',[$product->id,$imageKey]) }}" type="button" class="btn btn-sm btn--danger"><i class="fas fa-times mr-0"></i></a>
                                        <div class="image-upload">
                                            <div class="thumb">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview" style="background-image: url({{getImage(imagePath()['products']['path'].'/'.$image,'450x500')}})">
                                                    </div>
                                                </div>
                                                <div class="avatar-edit">
                                                    <input type="file" class="profilePicUpload" name="gallery[{{$imageKey}}]" id="profilePicUploadGal{{ $imageKey }}" accept=".png, .jpg, .jpeg">
                                                    <label for="profilePicUploadGal{{ $imageKey }}" class="bg--success">@lang('Upload Image')</label>
                                                    <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg.')</b> @lang('Image will be resized into 450x500') </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-12 mt-5">
            <div class="card">
                <div class="card-header font-weight-bold  bg--primary">@lang('SEO Contents')</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="" class="font-weight-bold">@lang('Meta Ttitle') <strong class="text-danger">*</strong></label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="meta_title" value="{{ @$product->meta_title}}" placeholder="@lang('Meta Title')">
                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="" class="font-weight-bold">@lang('Meta Keyword') <strong class="text-danger">*</strong></label>
                        </div>
                        <div class="col-md-10">
                            <select class="form-control select2-auto-tokenize" name="meta_keywords[]" multiple id="">
                                @if(@$product->meta_keyword && !empty(@$product->meta_keyword))
                                @foreach (@$product->meta_keyword as $keyword)
                                <option value="{{$keyword}}" selected>{{ $keyword}}</option>
                                @endforeach
                                @endif

                            </select>
                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="" class="font-weight-bold">@lang('Meta Description') <strong class="text-danger">*</strong></label>
                        </div>
                        <div class="col-md-10">
                            <textarea name="meta_description" class="form-control" placeholder="@lang('Meta Description')" id="" name="meta_description" cols="30" rows="10">{{@$product->meta_description}}</textarea>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-12 mt-5">
            <button type="submit" class="btn btn--primary btn-block">@lang('Update')</button>
        </div>

    </div>

</form>

@endsection



@push('breadcrumb-plugins')
<a href="{{ route('admin.product.index') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-backward"></i>@lang('Back')</a>

@endpush
@push('style')
<style>
    .profilePicUpload{
        height: 0px;
        padding: 0px;
    }
    .__gallery_image .form-group{
        position: relative;
    }
    .btn--danger{
        position: absolute;
        z-index: 99;
        top: 3px;
        right: 3px;
        border-radius: 5px;
    }
</style>
@endpush
@push('script')
<script>
    "use strict";
    (function($) {

        $(".add-specification").on('click', function(e) {
            let index = $(document).find(".specification").length;
            index = parseInt(index) + parseInt(1);

            let html = `
           <div class="row mb-2 specification">
            <div class="col-lg-5">
                <input type="text" class="form-control" name="specification[${index}][name]" placeholder="@lang('Enter Specification Name')">
            </div>
            <div class="col-lg-5">
                <input type="text" class="form-control" name="specification[${index}][value]" placeholder="@lang('Enter Specification Value')">
            </div>
            <div class="col-lg-2 text-right minus-specification">
                <a class="btn btn-outline--danger "><i class="la la-minus"></i></a>
            </div>
        </div>
           `;
            $("#specification").prepend(html)
            $("#specifications-title").hide()
        })
        $(".add-gallery-image").on('click', function(e) {
            let index = $(document).find(".__gallery_image").length;
            index = index + 1;

            let html = `
            <div class="col-lg-3 __gallery_image">
                <div class="form-group">
                    <button type="button" class="btn btn-sm btn--danger removeBtn"><i class="fas fa-times mr-0"></i></button>
                    <div class="image-upload">
                        <div class="thumb">
                            <div class="avatar-preview">
                                <div class="profilePicPreview" style="background-image: url({{ getImage('', '450x500') }})">
                                </div>
                            </div>
                            <div class="avatar-edit">
                                <input type="file" class="profilePicUpload" name="gallery[]" id="profilePicUploadItem${index}" accept=".png, .jpg, .jpeg">
                                <label for="profilePicUploadItem${index}" class="bg--success">Upload Image</label>
                                <small class="mt-2 text-facebook">Supported files: <b>jpeg, jpg.</b> Image will be resized into 450x500 </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           `;
            $("#__gallery_image").append(html)

        })

        $("body").on('click', '.minus-specification', function(e) {
            $(this).closest('.specification').remove();
            $(document).find(".specification").length <= 0 ? $("#specifications-title").show() : "" ;

        })

        $(document).on('click','.removeBtn',function (){
            $(this).closest('.__gallery_image').remove();
        });

        function proPicURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = $(input).parents('.thumb').find('.profilePicPreview');
                    $(preview).css('background-image', 'url(' + e.target.result + ')');
                    $(preview).addClass('has-image');
                    $(preview).hide();
                    $(preview).fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("body").on('change','.profilePicUpload',function() {
            proPicURL(this);
        });

        $('select[name=featured]').val({{ $product->is_featured }});

    })(jQuery);

</script>

<script src="{{ asset('assets/admin/js/status-switch.js') }}"></script>


@endpush
