<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Term;
use App\Models\Category;
use App\Models\Location;
use App\Models\Getway;
use Cart;
use Session;
use Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\SEOTools;
use Mail;
use App\Mail\ContactMail;


class PageController extends Controller
{
    public function home()
    {
      
        $home_data=optionfromcache('home_page');

        $seo=$home_data->seo ?? '';
        SEOMeta::setTitle($seo->site_title ?? '');
        SEOMeta::setDescription($seo->description ?? '');
       

        OpenGraph::setDescription($seo->description ?? '');
        OpenGraph::setTitle($seo->site_title ?? '');

        OpenGraph::addProperty('keywords', $seo->tags ?? '');

        TwitterCard::setTitle($seo->site_title ?? '');
        TwitterCard::setSite($seo->twitter_title ?? '');

        JsonLd::setTitle($seo->site_title ?? '');
        JsonLd::setDescription($seo->description ?? '');
        JsonLd::addImage($seo->meta_image ?? '');

        SEOTools::setTitle($seo->site_title ?? '');
        SEOTools::setDescription($seo->description ?? '');
        SEOTools::opengraph()->setUrl(url('/'));
      
        
        SEOTools::twitter()->setSite($seo->twitter_title ?? '');
        SEOTools::jsonLd()->addImage($seo->meta_image ?? '');
        SEOTools::opengraph()->addProperty('keywords', $seo->tags ?? '');

        $page_data=$home_data->meta ?? '';
        return view(baseview('index'),compact('page_data'));
    }

    public function category_product(Request $request)
    {
        $category=Category::with('products')->where('slug',$request->slug)->where('status',1)->first();
        return response()->json($category);
    }

    public function products(Request $request)
    {
        $home_data=optionfromcache('products_page');

        $seo=$home_data->seo ?? '';
        SEOMeta::setTitle($seo->site_title ?? '');
        SEOMeta::setDescription($seo->description ?? '');
       

        OpenGraph::setDescription($seo->description ?? '');
        OpenGraph::setTitle($seo->site_title ?? '');

        OpenGraph::addProperty('keywords', $seo->tags ?? '');

        TwitterCard::setTitle($seo->site_title ?? '');
        TwitterCard::setSite($seo->twitter_title ?? '');

        JsonLd::setTitle($seo->site_title ?? '');
        JsonLd::setDescription($seo->description ?? '');
        JsonLd::addImage($seo->meta_image ?? '');

        SEOTools::setTitle($seo->site_title ?? '');
        SEOTools::setDescription($seo->description ?? '');
        SEOTools::opengraph()->setUrl(url('/'));
        
        
        SEOTools::twitter()->setSite($seo->twitter_title ?? '');
        SEOTools::jsonLd()->addImage($seo->meta_image ?? '');
        SEOTools::opengraph()->addProperty('keywords', $seo->tags ?? '');

        $page_data=$home_data->meta ?? '';

        $page_title=$page_data->products_page_title ?? 'Products';
        $products_page_description=$page_data->products_page_description ?? '';
        $products_page_banner=$page_data->products_page_banner ?? '';
        $products_page_product_ads_banner=$page_data->products_page_product_ads_banner ?? '';
        $products_page_product_ads_link=$page_data->products_page_product_ads_link ?? '';

        return view(baseview('products'),compact('page_title','products_page_description','products_page_banner','products_page_product_ads_banner','products_page_product_ads_link','request'));
    }

    public function deals(Request $request)
    {
        $home_data=optionfromcache('deal_page');

        $seo=$home_data->seo ?? '';
        SEOMeta::setTitle($seo->site_title ?? '');
        SEOMeta::setDescription($seo->description ?? '');
       

        OpenGraph::setDescription($seo->description ?? '');
        OpenGraph::setTitle($seo->site_title ?? '');

        OpenGraph::addProperty('keywords', $seo->tags ?? '');

        TwitterCard::setTitle($seo->site_title ?? '');
        TwitterCard::setSite($seo->twitter_title ?? '');

        JsonLd::setTitle($seo->site_title ?? '');
        JsonLd::setDescription($seo->description ?? '');
        JsonLd::addImage($seo->meta_image ?? '');

        SEOTools::setTitle($seo->site_title ?? '');
        SEOTools::setDescription($seo->description ?? '');
       
        
        
        SEOTools::twitter()->setSite($seo->twitter_title ?? '');
        SEOTools::jsonLd()->addImage($seo->meta_image ?? '');
        SEOTools::opengraph()->addProperty('keywords', $seo->tags ?? '');

        $page_data=$home_data->meta ?? '';

        $page_title=$page_data->deal_page_title ?? 'Products';
        $products_page_description=$page_data->deal_page_description ?? '';
        $products_page_banner=$page_data->products_deal_banner ?? '';
        $products_page_product_ads_banner=$page_data->deal_page_product_ads_banner ?? '';
        $products_page_product_ads_link=$page_data->deal_page_product_ads_link ?? '';

        return view(baseview('deals'),compact('page_title','products_page_description','products_page_banner','products_page_product_ads_banner','products_page_product_ads_link','request'));
    }

    public function brand($slug)
    {
        $category=Category::where('type','brand')->with('preview','description')->where('slug',$slug)->where('status',1)->first();
        abort_if(empty($category),404);
        $categoryid=$category->id;

        $home_data=optionfromcache('products_page');

        $seo=$home_data->seo ?? '';

        SEOMeta::setTitle($category->name ?? '');
        SEOMeta::setDescription($category->description->content ?? '');
       

        OpenGraph::setDescription($category->description->content ?? '');
        OpenGraph::setTitle($category->name ?? '');

        OpenGraph::addProperty('keywords', $category->slug ?? '');

        TwitterCard::setTitle($category->name ?? '');
        TwitterCard::setSite($seo->twitter_title ?? '');

        JsonLd::setTitle($category->name ?? '');
        JsonLd::setDescription($category->description->content ?? '');
        JsonLd::addImage($category->preview->content ?? '');

        SEOTools::setTitle($category->name ?? '');
        SEOTools::setDescription($category->description->content ?? '');
        
        
        SEOTools::twitter()->setSite($category->name ?? '');
        SEOTools::jsonLd()->addImage($category->preview->content ?? '');
        SEOTools::opengraph()->addProperty('keywords', $category->name ?? '');

        

        $page_data=$home_data->meta ?? '';

        $page_title=$category->name ?? 'Products';
        $products_page_description=$category->description->content ?? '';
        $products_page_banner=$page_data->products_page_banner ?? '';
        $products_page_product_ads_banner=$page_data->products_page_product_ads_banner ?? '';
        $products_page_product_ads_link=$page_data->products_page_product_ads_link ?? '';

        return view(baseview('products'),compact('categoryid','page_data','page_title','products_page_description','products_page_banner','products_page_product_ads_banner','products_page_product_ads_link'));
    }

     public function featured($slug)
     {
        $category=Category::where('type','product_feature')->with('preview','description')->where('slug',$slug)->first();
        abort_if(empty($category),404);
        $categoryid=$category->id;

        $home_data=optionfromcache('products_page');

        $seo=$home_data->seo ?? '';

        SEOMeta::setTitle($category->name ?? '');
        SEOMeta::setDescription($category->description->content ?? '');
       

        OpenGraph::setDescription($category->description->content ?? '');
        OpenGraph::setTitle($category->name ?? '');

        OpenGraph::addProperty('keywords', $category->slug ?? '');

        TwitterCard::setTitle($category->name ?? '');
        TwitterCard::setSite($seo->twitter_title ?? '');

        JsonLd::setTitle($category->name ?? '');
        JsonLd::setDescription($category->description->content ?? '');
        JsonLd::addImage(asset($category->preview->content ?? ''));

        SEOTools::setTitle($category->name ?? '');
        SEOTools::setDescription($category->description->content ?? '');
        
        
        SEOTools::twitter()->setSite($category->name ?? '');
        SEOTools::jsonLd()->addImage(asset($category->preview->content ?? ''));
        SEOTools::opengraph()->addProperty('keywords', $category->name ?? '');

        

        $page_data=$home_data->meta ?? '';

        $page_title=$category->name ?? 'Products';
        $products_page_description=$category->description->content ?? '';
        $products_page_banner=$page_data->products_page_banner ?? '';
        $products_page_product_ads_banner=$page_data->products_page_product_ads_banner ?? '';
        $products_page_product_ads_link=$page_data->products_page_product_ads_link ?? '';

        return view(baseview('products'),compact('categoryid','page_data','page_title','products_page_description','products_page_banner','products_page_product_ads_banner','products_page_product_ads_link'));
    }

    public function tag($slug)
     {
        $category=Category::where('type','tag')->where('slug',$slug)->first();
        abort_if(empty($category),404);
        $categoryid=$category->id;

        $home_data=optionfromcache('products_page');

        $seo=$home_data->seo ?? '';

        SEOMeta::setTitle($category->name ?? '');
        OpenGraph::setTitle($category->name ?? '');
        OpenGraph::addProperty('keywords', $category->slug ?? '');
        TwitterCard::setTitle($category->name ?? '');
        JsonLd::setTitle($category->name ?? '');
        SEOTools::setTitle($category->name ?? '');
        SEOTools::twitter()->setSite($category->name ?? '');
        SEOTools::opengraph()->addProperty('keywords', $category->name ?? '');

        

        $page_data=$home_data->meta ?? '';

        $page_title=$category->name ?? 'Products';
        $products_page_description=$category->description->content ?? '';
        $products_page_banner=$page_data->products_page_banner ?? '';
        $products_page_product_ads_banner=$page_data->products_page_product_ads_banner ?? '';
        $products_page_product_ads_link=$page_data->products_page_product_ads_link ?? '';

        return view(baseview('products'),compact('categoryid','page_data','page_title','products_page_description','products_page_banner','products_page_product_ads_banner','products_page_product_ads_link'));
    }

    public function category($slug)
    {
        $category=Category::where('type','category')->with('preview','description')->where('slug',$slug)->where('status',1)->first();
        abort_if(empty($category),404);
        $categoryid=$category->id;
        $home_data=optionfromcache('products_page');

        $seo=$home_data->seo ?? '';

        SEOMeta::setTitle($category->name ?? '');
        SEOMeta::setDescription($category->description->content ?? '');
       

        OpenGraph::setDescription($category->description->content ?? '');
        OpenGraph::setTitle($category->name ?? '');

        OpenGraph::addProperty('keywords', $category->slug ?? '');

        TwitterCard::setTitle($category->name ?? '');
        TwitterCard::setSite($seo->twitter_title ?? '');

        JsonLd::setTitle($category->name ?? '');
        JsonLd::setDescription($category->description->content ?? '');
        JsonLd::addImage($category->preview->content ?? '');

        SEOTools::setTitle($category->name ?? '');
        SEOTools::setDescription($category->description->content ?? '');
        
        
        SEOTools::twitter()->setSite($category->name ?? '');
        SEOTools::jsonLd()->addImage($category->preview->content ?? '');
        SEOTools::opengraph()->addProperty('keywords', $category->name ?? '');

        

        $page_data=$home_data->meta ?? '';

        $page_title=$category->name ?? 'Products';
        $products_page_description=$category->description->content ?? '';
        $products_page_banner=$page_data->products_page_banner ?? '';
        $products_page_product_ads_banner=$page_data->products_page_product_ads_banner ?? '';
        $products_page_product_ads_link=$page_data->products_page_product_ads_link ?? '';

        return view(baseview('products'),compact('categoryid','page_data','page_title','products_page_description','products_page_banner','products_page_product_ads_banner','products_page_product_ads_link'));
    }

    public function productView($slug)
    {
        $info=Term::query()->where('type','product')->where('status',1)->with('tags','category','brands','excerpt','description','preview','medias','optionwithcategories','price','seo')->withCount('reviews')->where('slug',$slug)->first();
        abort_if(empty($info),404);
        $seo=json_decode($info->seo->value ?? '');

        $medias=json_decode($info->medias->value ?? '');

        

        $preview=asset($info->preview->value ?? 'uploads/default.png');
        $galleries=[];
        
        array_push($galleries,$preview);

        foreach($medias ?? [] as $row){
            array_push($galleries,$row);
        }

        SEOMeta::setTitle($seo->title ?? $info->title);
        SEOMeta::setDescription($seo->description ?? '');
        SEOMeta::addMeta('article:published_time', $info->updated_at->toW3CString(), 'property');
        SEOMeta::addKeyword([$seo->tags ?? '']);

        OpenGraph::setDescription($seo->description ?? '');
        OpenGraph::setTitle($seo->title ?? $info->title);
        
        OpenGraph::addProperty('type', 'article');

        OpenGraph::addImage($seo->preview ?? '');
        OpenGraph::addImage($galleries ?? []);
    
        JsonLd::setTitle($seo->title ?? $info->title);
        JsonLd::setDescription($seo->description ?? '');
        JsonLd::addImage($seo->preview ?? '');
        JsonLd::addImage($galleries ?? []);

        $home_data=optionfromcache('product_page');

        $home_data=$home_data->meta ?? '';
       
        return view(baseview('details'),compact('info','galleries','home_data'));
    }

    public function page($slug)
    {
        $info=Term::query()->where('type','page')->where('status',1)->where('slug',$slug)->with('meta')->first();
        abort_if(empty($info),404);
        $meta=json_decode($info->meta->value ?? '');

        JsonLdMulti::setTitle($info->title ?? '');
        JsonLdMulti::setDescription($meta->page_excerpt ?? null);
        JsonLdMulti::addImage(asset('uploads/'.tenant('uid').'/logo.png'));

        SEOMeta::setTitle($info->title ?? '');
        SEOMeta::setDescription($meta->page_excerpt ?? null);
     
        SEOTools::setTitle($info->title ?? '');
        SEOTools::setDescription($meta->page_excerpt ?? null);
     
        SEOTools::opengraph()->addProperty('image', asset('uploads/'.tenant('uid').'/logo.png'));
        SEOTools::twitter()->setTitle($info->title ?? '');
        SEOTools::twitter()->setSite($info->title ?? '');
        SEOTools::jsonLd()->addImage(asset('uploads/'.tenant('uid').'/logo.png'));

        return view(baseview('page'),compact('info','meta'));
    }

    public function menu()
    {
        $home_data=optionfromcache('menu_page');

        $seo=$home_data->seo ?? '';
        SEOMeta::setTitle($seo->site_title ?? '');
        SEOMeta::setDescription($seo->description ?? '');
       

        OpenGraph::setDescription($seo->description ?? '');
        OpenGraph::setTitle($seo->site_title ?? '');

        OpenGraph::addProperty('keywords', $seo->tags ?? '');

        TwitterCard::setTitle($seo->site_title ?? '');
        TwitterCard::setSite($seo->twitter_title ?? '');

        JsonLd::setTitle($seo->site_title ?? '');
        JsonLd::setDescription($seo->description ?? '');
        JsonLd::addImage($seo->meta_image ?? '');

        SEOTools::setTitle($seo->site_title ?? '');
        SEOTools::setDescription($seo->description ?? '');
        SEOTools::opengraph()->setUrl(url('/'));
       
        
        SEOTools::twitter()->setSite($seo->twitter_title ?? '');
        SEOTools::jsonLd()->addImage($seo->meta_image ?? '');
        SEOTools::opengraph()->addProperty('keywords', $seo->tags ?? '');

        $page_data=$home_data->meta ?? '';
        return view(baseview('menu'),compact('page_data'));
    }

    public function cart()
    {
        $tax=optionfromcache('tax');
        if ($tax == null) {
            $tax=0;
        }
        Cart::setGlobalTax($tax);

        $home_data=optionfromcache('cart_page');

        $seo=$home_data->seo ?? '';
        SEOMeta::setTitle($seo->site_title ?? '');
        SEOMeta::setDescription($seo->description ?? '');
       

        OpenGraph::setDescription($seo->description ?? '');
        OpenGraph::setTitle($seo->site_title ?? '');

        OpenGraph::addProperty('keywords', $seo->tags ?? '');

        TwitterCard::setTitle($seo->site_title ?? '');
        TwitterCard::setSite($seo->twitter_title ?? '');

        JsonLd::setTitle($seo->site_title ?? '');
        JsonLd::setDescription($seo->description ?? '');
        JsonLd::addImage($seo->meta_image ?? '');

        SEOTools::setTitle($seo->site_title ?? '');
        SEOTools::setDescription($seo->description ?? '');
        SEOTools::opengraph()->setUrl(url('/'));
      
        
        SEOTools::twitter()->setSite($seo->twitter_title ?? '');
        SEOTools::jsonLd()->addImage($seo->meta_image ?? '');
        SEOTools::opengraph()->addProperty('keywords', $seo->tags ?? '');

        $page_data=$home_data->meta ?? '';

        return view(baseview('cart'),compact('page_data'));
    }

    public function wishlist()
    {

        $tax=optionfromcache('tax');
        if ($tax == null) {
            $tax=0;
        }
        Cart::setGlobalTax($tax);
        $contents=Cart::instance('wishlist')->content();


        $home_data=optionfromcache('wishlist_page');

        $seo=$home_data->seo ?? '';
        SEOMeta::setTitle($seo->site_title ?? '');
        SEOMeta::setDescription($seo->description ?? '');
       

        OpenGraph::setDescription($seo->description ?? '');
        OpenGraph::setTitle($seo->site_title ?? '');

        OpenGraph::addProperty('keywords', $seo->tags ?? '');

        TwitterCard::setTitle($seo->site_title ?? '');
        TwitterCard::setSite($seo->twitter_title ?? '');

        JsonLd::setTitle($seo->site_title ?? '');
        JsonLd::setDescription($seo->description ?? '');
        JsonLd::addImage($seo->meta_image ?? '');

        SEOTools::setTitle($seo->site_title ?? '');
        SEOTools::setDescription($seo->description ?? '');
        SEOTools::opengraph()->setUrl(url('/'));
       
        
        SEOTools::twitter()->setSite($seo->twitter_title ?? '');
        SEOTools::jsonLd()->addImage($seo->meta_image ?? '');
        SEOTools::opengraph()->addProperty('keywords', $seo->tags ?? '');

        $page_data=$home_data->meta ?? '';
        return view(baseview('wishlist'),compact('contents','page_data'));
    }

    public function checkout(Request $request)
    {
        $tax=optionfromcache('tax');
        if ($tax == null) {
            $tax=0;
        }
        Cart::setGlobalTax($tax);
        $order_settings=get_option('order_settings',true);
        if ($order_settings->shipping_amount_type != 'distance') {
            $locations=Location::where([['status',1]])->whereHas('shippings')->with('shippings')->get();
        }
        else{
            $locations=[];
        }
        
        $getways=Getway::where('status','!=',0)->get();

        $order_method=$request->t ?? 'delivery';
        
        $invoice_data=optionfromcache('invoice_data');
        
        $meta= !Auth::check() ? [] : json_decode(Auth::user()->meta ?? '');

        

        $home_data=optionfromcache('checkout_page');

        $seo=$home_data->seo ?? '';
        SEOMeta::setTitle($seo->site_title ?? '');
        SEOMeta::setDescription($seo->description ?? '');
       

        OpenGraph::setDescription($seo->description ?? '');
        OpenGraph::setTitle($seo->site_title ?? '');

        OpenGraph::addProperty('keywords', $seo->tags ?? '');

        TwitterCard::setTitle($seo->site_title ?? '');
        TwitterCard::setSite($seo->twitter_title ?? '');

        JsonLd::setTitle($seo->site_title ?? '');
        JsonLd::setDescription($seo->description ?? '');
        JsonLd::addImage($seo->meta_image ?? '');

        SEOTools::setTitle($seo->site_title ?? '');
        SEOTools::setDescription($seo->description ?? '');
        SEOTools::opengraph()->setUrl(url('/'));
    
        
        SEOTools::twitter()->setSite($seo->twitter_title ?? '');
        SEOTools::jsonLd()->addImage($seo->meta_image ?? '');
        SEOTools::opengraph()->addProperty('keywords', $seo->tags ?? '');

        $page_data=$home_data->meta ?? '';

        $pickup_order=$order_settings->pickup_order ?? 'off';
        $pre_order=$order_settings->pre_order ?? 'off';
        $source_code=$order_settings->source_code ?? 'on';
        return view(baseview('checkout'),compact('locations','getways','request','order_method','order_settings','invoice_data','meta','page_data','pickup_order','pre_order','source_code'));
    }

    public function thanks()
    {
        abort_if(!Session::has('invoice_no'),404);
        $orderno=Session::get('invoice_no');
        SEOMeta::setTitle($orderno.' - Thanks');
        return view(baseview('thanks'),compact('orderno'));
    }

    public function contact()
    {
        $home_data=optionfromcache('contact_page');

        $seo=$home_data->seo ?? '';
        SEOMeta::setTitle($seo->site_title ?? '');
        SEOMeta::setDescription($seo->description ?? '');
       

        OpenGraph::setDescription($seo->description ?? '');
        OpenGraph::setTitle($seo->site_title ?? '');

        OpenGraph::addProperty('keywords', $seo->tags ?? '');

        TwitterCard::setTitle($seo->site_title ?? '');
        TwitterCard::setSite($seo->twitter_title ?? '');

        JsonLd::setTitle($seo->site_title ?? '');
        JsonLd::setDescription($seo->description ?? '');
        JsonLd::addImage($seo->meta_image ?? '');

        SEOTools::setTitle($seo->site_title ?? '');
        SEOTools::setDescription($seo->description ?? '');
        SEOTools::opengraph()->setUrl(url('/'));
       
        
        SEOTools::twitter()->setSite($seo->twitter_title ?? '');
        SEOTools::jsonLd()->addImage($seo->meta_image ?? '');
        SEOTools::opengraph()->addProperty('keywords', $seo->tags ?? '');

        $page_data=$home_data->meta ?? '';
        return view(baseview('contact'),compact('page_data'));
    }

    public function contact_send(Request $request)
    {
        
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|max:50',
            'subject' => 'required|max:200',
            'message' => 'required|max:500'
        ]);

        $data = [
            'name' => $request->name,
            'message' => $request->message,
            'subject' => $request->subject,
            'email'=>$request->email
        ];

        Mail::to(get_option('invoice_data',true)->store_legal_email)->send(new ContactMail($data));

        return response()->json('Message Send Successfully');
    }

}
