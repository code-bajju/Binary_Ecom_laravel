<?php

namespace App\Http\Controllers;
use App\Models\AdminNotification;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\Product;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;


class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }

        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle = 'Home';
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','home')->first();
        return view($this->activeTemplate . 'home', compact('pageTitle','sections'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle','sections'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        $contact = Frontend::where('data_keys','contact_us.content')->first();
        $informations = Frontend::where('data_keys','contact_us.element')->get();
        return view($this->activeTemplate . 'contact',compact('pageTitle','contact','informations'));
    }


    public function contactSubmit(Request $request)
    {

        $attachments = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);


        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blogDetails($id,$slug){
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $pageTitle = $blog->data_values->title;
        return view($this->activeTemplate.'blog_details',compact('blog','pageTitle'));
    }


    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        return 'success';
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }


    public function CheckUsername(Request $request)
    {
        $id = User::where('username', $request->ref_id)->first();
        if ($id == '') {
            return response()->json(['success' => false, 'msg' => "<span class='help-block'><strong class='text-danger'>Referrer username not found</strong></span>"]);
        } else {
            return response()->json(['success' => true, 'msg' => "<span class='help-block'><strong class='text-success'>Referrer username matched</strong></span>
                     <input type='hidden' id='referrer_id' value='$id->id' name='referrer_id'>"]);

        }
    }


    public function userPosition(Request $request)
    {

        if (!$request->referrer) {
            return response()->json(['success' => false, 'msg' => "<span class='help-block'><strong class='text-danger'>Inter Referral name first</strong></span>"]);
        }
        if (!$request->position) {
            return response()->json(['success' => false, 'msg' => "<span class='help-block'><strong class='text-danger'>Select your position*</strong></span>"]);
        }
        $user = User::find($request->referrer);
        $pos = getPosition($user->id, $request->position);
        $join_under = User::find($pos['pos_id']);
        if ($pos['position'] == 1)
            $position = 'Left';
        else {
            $position = 'Right';
        }
        return response()->json(['success' => true, 'msg' => "<span class='help-block'><strong class='text-success'>You are joining under $join_under->username at $position  </strong></span>"]);
    }

    public function products($categoryId = null)
    {
        $pageTitle = "Products";
        $products = Product::query();
        if($categoryId){
            $products = $products->where('category_id',$categoryId);
        }
        $products = $products->latest()->with('category')->paginate(getPaginate());
        $categories = Category::where('status',1)->get()->take(4);
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','product')->first();
        return view($this->activeTemplate.'products',compact('pageTitle','products','categories','categoryId','sections'));
    }

    public function productDetails($id){
        $product = Product::hasCategory()->where('id',$id)->where('status',1)->firstOrFail();
        $pageTitle= "Products: ".$product->name;
        $relateds = Product::where('category_id',$product->category_id)->where('id','!=',$product->id)->orderBy('id','desc')->limit(10)->get();
        $seoContent = (object)getSeocontent($product);
        return view($this->activeTemplate.'product_detail',compact('pageTitle','product','relateds','seoContent'));
    }

    public function policy($slug,$id)
    {
        $policy = Frontend::where('data_keys', 'policy_pages.element')->where('id',$id)->first();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate.'policy',compact('pageTitle','policy'));
    }

    public function blog()
    {
        $blogs = Frontend::where('data_keys', 'blog.element')->latest()->paginate(12);
        $page = Page::where('tempname', $this->activeTemplate)->where('slug', 'blog')->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page;
        return view($this->activeTemplate . 'blog',compact('pageTitle','blogs','sections'));
    }

    public function blogDeatail($slug, $id)
    {
        $blog = Frontend::where('data_keys', 'blog.element')->where('id', $id)->firstOrFail();
        $latestBlogs = Frontend::where('id', '!=', $id)->where('data_keys', 'blog.element')->take(5)->get();
        $pageTitle = "Details";
        return view($this->activeTemplate . 'blog_details',compact('pageTitle','blog','latestBlogs'));
    }

}
