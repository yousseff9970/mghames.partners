<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use Auth;
class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!Auth()->user()->can('seo.settings'), 401);
      $data = Option::where('key', 'seo_home')->orWhere('key', "seo_blog")->orWhere('key', "seo_service")->orWhere('key', "seo_contract")->orWhere('key', "seo_pricing")->get();


       return view('admin.seo.index',compact('data'));
    }

    public function edit($id)
    {
         abort_if(!Auth()->user()->can('seo.settings'), 401);
       $data = Option::where('id', $id)->first();
       return view('admin.seo.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $option = Option::where('id', $id)->first();

        $data = [
            "site_name"          => $request->site_name,
            "matatag"            => $request->matatag,
            "twitter_site_title" => $request->twitter_site_title,
            "matadescription"    => $request->matadescription,
        ];

        $value         = json_encode($data);
        $option->value = $value;
        $option->save();
        return response()->json('Successfully Updated');
    }

  

}
