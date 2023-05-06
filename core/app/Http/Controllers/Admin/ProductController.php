<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    public function index()
    {

        $pageTitle = 'Product List';
        $emptyMessage = 'No product available.';
        $products = Product::with('category')->latest()->paginate(getPaginate());
        return view('admin.product.index', compact('pageTitle', 'emptyMessage', 'products'));
    }

    public function create()
    {
        $pageTitle = 'Create Products';
        $categories = Category::where('status', 1)->get();
        return view('admin.product.create', compact('pageTitle', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'                             =>    'required',
            'category'                         =>    'required',
            'featured'                         =>    'required|in:1,0',
            'price'                            =>    'required|numeric|gt:0',
            'quantity'                         =>    'required|integer|gt:0',
            'bv'                               =>    'required|integer|gt:0',
            'description'                      =>    'required',
            'specification.*.name'             =>    'required|sometimes',
            'specification.*.value'            =>    'required|sometimes',
            'gallery.*'                        =>    ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'thumbnail'                         =>    ['required', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],

        ], [

            'specification.*.name.required'   =>      "All specification name filed is required",
            'specification.*.value.required'  =>      "All specification value filed is required",

        ]);

        $category = Category::where('status',1)->findOrFail($request->category);

        $product = new Product();
        $product->category_id = $category->id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->is_featured = $request->featured;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_keyword = $request->meta_keywords;
        $product->bv = $request->bv;

        if ($request->hasFile('thumbnail')) {
            $product->thumbnail = $this->uploadThumbnail($request->file('thumbnail'));
        }


        if ($request->hasFile('gallery')) {
            $product->images = $this->uploadGalleryImage($request->file('gallery'));
        }

        if ($request->specification) {
            $product->specifications = array_values($request->specification);
        }
        $product->save();
        $notify[] = ['success', 'Product has been saved successfully'];
        return back()->withNotify($notify);
    }



    public function edit($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $pageTitle = 'Edit Product:' . $product->name;
        $categories = Category::where('status', 1)->get();
        return view('admin.product.edit', compact('pageTitle', 'categories', 'product'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'name'                             =>    'required',
            'category'                         =>    'required',
            'featured'                         =>    'required|in:1,0',
            'price'                            =>    'required|numeric|gt:0',
            'quantity'                         =>    'required|integer|gt:0',
            'bv'                               =>    'required|integer|gt:0',
            'description'                      =>    'required',
            'specification.*.name'             =>    'required|sometimes',
            'specification.*.value'            =>    'required|sometimes',
            'galleryImages.*'                  =>    ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'thumbnail'                         =>    ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],

        ], [

            'specification.*.name.required'   =>      "All specification name filed is required",
            'specification.*.value.required'  =>      "All specification value filed is required",
        ]);

        $category = Category::where('status',1)->findOrFail($request->category);
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->category_id = $category->id;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->meta_title = $request->meta_title;
        $product->is_featured = $request->featured;
        $product->meta_description = $request->meta_description;
        $product->bv = $request->bv;

        ///update thumbnail
        if ($request->hasFile('thumbnail')) {
            $product->thumbnail = $this->uploadThumbnail($request->file('thumbnail'), $product->thumbnail);
        }

        ///update the product image gallery
        if ($request->hasFile('gallery')) {
            $existImage = $product->images;
            $newImages = $this->uploadGalleryImage($request->file('gallery'));

            foreach ($newImages as $k =>  $newIimage) {
                if (isset($existImage[$k])) {
                    removeFile(imagePath()['products']['path'] . '/' . $existImage[$k]);
                }
                $existImage[$k] = $newImages[$k];
            }
            $product->images = $existImage;
        }
        if ($request->specification) {
            $product->specifications = array_values($request->specification);
        }else{
            $product->specifications = null;
        }

        $product->save();

        $notify[] = ['success', 'Product has been updated successfully'];
        return back()->withNotify($notify);
    }


    public function destroy($id)
    {
        //
    }

    public function uploadGalleryImage($images)
    {

        $path = imagePath()['products']['path'];
        $galleryImage = [];
        foreach ($images as $k => $image) {
            $galleryImage[$k] = uploadImage($image, $path);
        }
        return $galleryImage;
    }

    public  function uploadThumbnail($image, $old = null)
    {

        $path = imagePath()['products']['path'];
        $size = imagePath()['products']['size'];
        $thumb = imagePath()['products']['thumb'];
        $thumbnail = uploadImage($image, $path, $size, $old, $thumb);

        return $thumbnail;
    }

    public function changeStatus($id)
    {
        $product=Product::findOrFail($id);
        $product->status= !$product->status;
        $product->save();
        $notify[] = ['success', 'Product status has been change successfully'];
        return back()->withNotify($notify);
    }

    public function removeImage($id,$key){
        $product = Product::findOrFail($id);
        $gallery = $product->images;
        $removeAble = @$gallery[$key];
        if(!$removeAble){
            abort(404);
        }
        unset($gallery[$key]);
        removeFile(imagePath()['products']['path'] . '/' . $removeAble);
        $product->images = $gallery;
        $product->save();
        $notify[] = ['success','Product image removed successfully'];
        return back()->withNotify($notify);
    }
}
