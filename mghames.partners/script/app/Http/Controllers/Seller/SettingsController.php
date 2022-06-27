<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Review;
use Auth;
use Illuminate\Http\Request;
use Hash;
use Carbon\Carbon;
use File;

class SettingsController extends Controller
{
    public function index()
    {
        abort_if(!getpermission('website_settings'),401);
        return view('seller.settings.index');
    }

    public function update(Request $request)
    {
        
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
        ]);

        $user = Auth::User();
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->old_password || $request->password)
        {
            $request->validate([
                'old_password' => 'required|password',
                'password' => 'required|confirmed',
            ]);

            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json('Profile Updated');
    }

    public function pwa()
    {
         abort_if(!getpermission('website_settings'),401);
         abort_if(tenant('pwa') != 'on',404);
        if (file_exists('uploads/'.tenant('uid').'/manifest.json')) {
              $pwa=file_get_contents('uploads/'.tenant('uid').'/manifest.json');
              $pwa=json_decode($pwa);
        }
        else{
            $pwa=[];
        }

        
        return view('seller.settings.pwa',compact('pwa'));
    }

    public function custom_css_js()
    {
        abort_if(!getpermission('website_settings'),401);
        abort_if(tenant('custom_css_js') != 'on',404);

        if (file_exists('uploads/'.tenant('uid'). '/custom.css')) {
            $css=file_get_contents('uploads/'.tenant('uid').'/custom.css');
        }
        else{
            $css='';
        }

        if (file_exists('uploads/'.tenant('uid'). '/custom.js')) {
            $js=file_get_contents('uploads/'.tenant('uid').'/custom.js');
        }
        else{
            $js='';
        }

        return view('seller.settings.custom_css_js',compact('css','js'));
    }

    public function custom_css_js_update(Request $request)
    {
        abort_if(!getpermission('website_settings'),401);
        $request->validate([
            'css' => 'max:1000',
            'js' => 'max:1000'
        ]);
        if (tenant('custom_css_js') != 'on') {
            $errors['errors']['error']='Custom css js not supported in your subscription';
            return response()->json($errors,401);
        }

        File::put('uploads/'.tenant('uid').'/custom.css',$request->css);
        File::put('uploads/'.tenant('uid').'/custom.js',$request->js);

        return response()->json('Addition Css & Js Successfully Updated');
    }


    public function pwa_update(Request $request)
    {
        if (tenant('pwa') != 'on') {
            $errors['errors']['error']='PWA Modules not supported in your subscription';
            return response()->json($errors,401);
        }

        $request->validate([
            'pwa_app_title' => 'required',
            'pwa_app_name' => 'required',
            'pwa_app_background_color' => 'required',
            'pwa_app_theme_color' => 'required',
            'app_lang' => 'required',
            'app_icon_128x128' => 'image|max:100|dimensions:max_width=128,max_height=128',
            'app_icon_144x144' => 'image|max:100|dimensions:max_width=144,max_height=144',
            'app_icon_152x152' => 'image|max:100|dimensions:max_width=152,max_height=152',
            'app_icon_192x192' => 'image|max:100|dimensions:max_width=192,max_height=192',
            'app_icon_512x512' => 'image|max:100|dimensions:max_width=512,max_height=512',
            'app_icon_256x256' => 'image|max:100|dimensions:max_width=256,max_height=256'
        ]);

       
        $user_id=tenant('uid');
        

         if ($request->app_icon_128x128) {
             $request->app_icon_128x128->move('uploads/'.$user_id, '128x128.png'); 
        }
        if ($request->app_icon_144x144) {
           $request->app_icon_144x144->move('uploads/'.$user_id, '144x144.png'); 
        }
        if ($request->app_icon_152x152) {
           $request->app_icon_152x152->move('uploads/'.$user_id, '152x152.png'); 
        }
        if ($request->app_icon_192x192) {
         $request->app_icon_192x192->move('uploads/'.$user_id, '192x192.png'); 
        }
        if ($request->app_icon_512x512) {
         $request->app_icon_512x512->move('uploads/'.$user_id, '512x512.png'); 
        }
        if ($request->app_icon_256x256) {
         $request->app_icon_256x256->move('uploads/'.$user_id, '256x256.png'); 
        }



        
$mainfest='{
"name": "'.$request->pwa_app_title.'",
"short_name": "'.$request->pwa_app_name.'",
"icons": [
    {
      "src": "'.asset('uploads/'.$user_id.'/128x128.png').'",
      "sizes": "128x128",
      "type": "image/png"
    },
    {
      "src": "'.asset('uploads/'.$user_id.'/144x144.png').'",
      "sizes": "144x144",
      "type": "image/png"
    },
    {
      "src": "'.asset('uploads/'.$user_id.'/152x152.png').'",
      "sizes": "152x152",
      "type": "image/png"
    },
    {
      "src": "'.asset('uploads/'.$user_id.'/192x192.png').'",
      "sizes": "192x192",
      "type": "image/png"
    },
    {
      "src": "'.asset('uploads/'.$user_id.'/256x256.png').'",
      "sizes": "256x256",
      "type": "image/png"
    },
    {
      "src": "'.asset('uploads/'.$user_id.'/512x512.png').'",
      "sizes": "512x512",
      "type": "image/png"
    }
  ],
"lang": "'.$request->app_lang.'",
"start_url": "/pwa",
"display": "standalone",
"background_color": "'.$request->pwa_app_background_color.'",
"theme_color": "'.$request->pwa_app_theme_color.'"
}';

\File::put('uploads/'.$user_id.'/manifest.json',$mainfest);
        return response()->json('PWA Sucessfully Updated');
    }
}
