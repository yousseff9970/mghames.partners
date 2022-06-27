<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use App\Models\Term;
use Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\SEOTools;
use Newsletter;
class CustomerController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
          'email' => 'required|email|max:100',
        ]);
        $mailchimp=get_option('mailchimp',true);
        $mailchimp=$mailchimp->meta ?? '';
        \Config::set('newsletter.apiKey', $mailchimp->mailchimp_api_key);
        \Config::set('newsletter.lists.subscribers.id', $mailchimp->mailchimp_list_id);

        Newsletter::subscribe($request->email);
       return response()->json('Thanks for subscribe');
    }

    public function login()
    {
        abort_if(tenant('customer_modules') != 'on',404);
        
        $home_data=optionfromcache('login_page');

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
        SEOTools::setCanonical(url('/'));
        
        SEOTools::twitter()->setSite($seo->twitter_title ?? '');
        SEOTools::jsonLd()->addImage($seo->meta_image ?? '');
        SEOTools::opengraph()->addProperty('keywords', $seo->tags ?? '');

        
       return view(baseview('customer/login'));
    }

    public function register()
    {
        abort_if(tenant('customer_modules') != 'on',404);

        $home_data=optionfromcache('register_page');
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
        SEOTools::setCanonical(url('/'));
        
        SEOTools::twitter()->setSite($seo->twitter_title ?? '');
        SEOTools::jsonLd()->addImage($seo->meta_image ?? '');
        SEOTools::opengraph()->addProperty('keywords', $seo->tags ?? '');

        
        return view(baseview('customer/register'));
    }

    public function registerCustomer(Request $request)
    {
        abort_if(tenant('customer_modules') != 'on',404);
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = new User();
        $user->role_id = 4;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = \Hash::make($request->password);
        $user->status = 1;
        $user->save();

        Auth::loginUsingId($user->id);

        return redirect('/customer/dashboard');
    }

    public function dashboard()
    {
        abort_if(tenant('customer_modules') != 'on',404);
        $total_orders=Order::where('user_id',Auth::id())->count();
        $total_pending_orders=Order::where('user_id',Auth::id())->where('status_id','!=',2)->where('status_id','!=',1)->count();
        $orders=Order::where('user_id',Auth::id())->with('orderstatus')->latest()->take(5)->get();
        
        SEOMeta::setTitle('Dashboard');
        return view(baseview('customer/dashboard'),compact('total_orders','total_pending_orders','orders'));
    }

    public function orders()
    {
        abort_if(tenant('customer_modules') != 'on',404);
        $orders=Order::where('user_id',Auth::id())->with('orderstatus')->withCount('orderitems')->latest()->paginate(10);
        SEOMeta::setTitle('Orders');
        return view(baseview('customer/orders'),compact('orders'));
    }

    public function orderview($id)
    {
        abort_if(tenant('customer_modules') != 'on',404);
        $info=Order::where('user_id',Auth::id())->with('orderitemswithpreview','shippingwithinfo','orderstatus','ordermeta','schedule','reviews')->findorFail($id);
        SEOMeta::setTitle($info->invoice_no);
        $reviews=[];
        foreach($info->reviews ?? [] as $row){
            $reviews[$row->term_id]['rating']=$row->rating;
            $reviews[$row->term_id]['comment']=$row->comment;
        }
       
        return view(baseview('customer/order'),compact('info','reviews'));
    }

    public function settings()
    {
        abort_if(tenant('customer_modules') != 'on',404);
        $meta=json_decode(Auth::user()->meta ?? '');
        $order_settings=get_option('order_settings',true);
        SEOMeta::setTitle('Settings');
        return view(baseview('customer/settings'),compact('meta','order_settings'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|max:50|email|unique:users,email,' . Auth::user()->id,
            'phone' => 'required|max:20',
            'address' => 'max:300',
            'post_code' => 'max:10',
            'lat' => 'max:300',
            'long' => 'max:300',
        ]);

        $data['address']=$request->address;
        $data['post_code']=$request->post_code;
        $data['lat']=$request->lat;
        $data['long']=$request->long;

        $user= User::findOrFail(Auth::user()->id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->phone=$request->phone;
        $user->meta=json_encode($data);
        $user->save();

        return response()->json('Successfully your information updated...!!');
    }

    public function profilePasswordUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);
        $info=User::where('id',Auth::id())->first();

        $check=\Hash::check($request->current, auth()->user()->password);
        
        if ($check==true) {
            User::where('id',Auth::id())->update(['password'=>\Hash::make($request->password)]);

            return response()->json(['Password Changed']); 

        }
        else{
            $error['errors']['domain']='Enter Valid Password';
            return response()->json($error,422);
         
        }
   }

    public function reviews()
    {
        abort_if(tenant('customer_modules') != 'on',404);
        $posts=Review::where('user_id',Auth::id())->whereHas('order')->with('order')->latest()->paginate(20);
        return view(baseview('customer/reviews'),compact('posts'));
    }

    public function makeReview(Request $request,$orderid,$termid,$optionid)
    {

        $request->validate([
            'rating' => 'required|max:5',
            'feedback' => 'required|max:200',
        ]);

        $order_info=Order::where('user_id',Auth::id())->whereHas('orderitems',function($q) use ($termid) {
            return $q->where('term_id',$termid);
        })->find($orderid);

        abort_if(empty($order_info) || $request->rating == 0,404);

       $review=Review::where('order_id',$orderid)->where('user_id',Auth::id())->where('term_id',$termid)->first();
       if (empty($review)) {
           $review=new Review;
       }


       $review->user_id=Auth::id();
       $review->order_id=$orderid;
       $review->term_id=$termid;
       $review->rating=$request->rating;
       $review->comment=$request->feedback;
       $review->save();

       $avg_ratings=Review::where('term_id',$termid)->avg('rating');

       $term=Term::findOrFail($termid);
       $term->rating=$avg_ratings;
       $term->save();

       return response()->json('Review Added Successfully');


    }
}
