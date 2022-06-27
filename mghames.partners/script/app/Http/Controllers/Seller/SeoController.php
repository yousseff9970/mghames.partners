<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Auth;
class SeoController extends Controller
{
    public function index()
    {
          abort_if(!getpermission('website_settings'),401);
         
        $theme=tenant('theme') != null ? tenant('theme') : 'theme.resto';
        $theme=str_replace('.','/',$theme);

        $functions= resource_path('views/'.$theme.'/options.php');
        include($functions);

        
        return view('seller.seo.index',compact(['pages']));
    }

    public function update(Request $request,$page)
    {
          abort_if(!getpermission('website_settings'),401);
        $request->validate([
            'site_title' => 'required|max:100',
            'twitter_title' => 'required|max:100',
            'tags' => 'required|max:500',
            'description' => 'required|max:2000'
        ]);

        $theme=tenant('theme') != null ? tenant('theme') : 'theme.resto';
        $theme=str_replace('.','/',$theme);

        $functions= resource_path('views/'.$theme.'/options.php');
        include($functions);

        abort_if(!in_array($page,$pages),404);

        $seo_data = [
            'site_title' => $request->site_title,
            'twitter_title' => $request->twitter_title,
            'tags' => $request->tags,
            'description' => $request->description,
            'meta_image' => $request->meta_image
        ];

       

        $option=Option::where('key',$page)->first();

       if (empty($option)) {
          $option=new Option;
          $option->key=$page;
          $data['seo']=$seo_data;
          $option->value=json_encode($data);
       }
       else{
          $data=json_decode($option->value ?? '');
          $data->seo=$seo_data;
          $option->value=json_encode($data);
       }

        
        $option->save();

        TenantCacheClear($page);

        return response()->json('SEO Info Updated');
    }
}
