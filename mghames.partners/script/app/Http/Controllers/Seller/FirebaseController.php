<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Devicetoken;
use Auth;
use App\Lib\NotifyToUser;

class FirebaseController extends Controller
{

    public function index(Request $request)
    {
       abort_if(!getpermission('website_settings'),401);
        $posts=Devicetoken::with('user')->latest()->paginate(20);
        return view('seller.notification.index',compact('posts','request'));
    }

    public function create()
    {
         abort_if(!getpermission('website_settings'),401);
        return view('seller.notification.create');
    }

    public function store(Request $request)
    {
        abort_if(!getpermission('website_settings'),401);
       $tokens=Devicetoken::pluck('token')->all();
       if (count($tokens ?? []) == 0) {
            $errors['errors']['error']='Subscribers not available';
            return response()->json($errors,401);
       }

       $sent=NotifyToUser::fmc($request->title,$request->description,url('/'),asset('uploads/'.tenant('uid').'/notification.png'),$tokens);
        if ($sent == false) {
            $errors['errors']['error']='Something wrong';
            return response()->json($errors,401);
        }

       return response()->json(['Notification successfully delivered']);
    }

    public function show($id)
    {
        abort_if(!getpermission('website_settings'),401);
        $posts=Devicetoken::findorFail($id);
        return view('seller.notification.show',compact('id'));

    }

    public function update(Request $request,$id)
    {
        abort_if(!getpermission('website_settings'),401);
        $posts=Devicetoken::findorFail($id);
        $sent=NotifyToUser::fmc($request->title,$request->description,url('/'),asset('uploads/'.tenant('uid').'/notification.png'),[$posts->token]);
        if ($sent == false) {
            $errors['errors']['error']='Something wrong';
            return response()->json($errors,401);
        }

       return response()->json(['Notification successfully delivered']);
    }

   /** 
     * Write code on Method
     *
     * @return response()
     */
    public function saveToken(Request $request)
    {
        if(tenant('push_notification') != 'on'){
            $errors['errors']['error']='Notification modules not supported in your plan';
            return response()->json($errors,401);
        }

        $token=Devicetoken::where('user_id',Auth::id())->first();
        if (empty($token)) {
           $token=new Devicetoken;
           $token->user_id=Auth::id();
        }
        $token->token=$request->token;
        $token->save();

        return response()->json(['Notification successfully enabled']);
    }
  
    

    public function destroy(Request $request)
    {
        abort_if(!getpermission('website_settings'),401);
        if ($request->status != 'delete') {
            $errors['errors']['error']='Select Delete Method';
            return response()->json($errors,401);
        }

        if (count($request->id ?? []) == 0) {
            $errors['errors']['error']='Select Some Token';
            return response()->json($errors,401);
        }
        Devicetoken::whereIn('id',$request->id)->delete();

        return response()->json('Token Removed');
    }
}
