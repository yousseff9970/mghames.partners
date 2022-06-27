<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
class FeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         abort_if(!getpermission('products'),401);
         $posts=Category::where('type','product_feature')->with('preview');
         if ($request->src) {
            $posts=$posts->where('name','LIKE','%'.$request->src.'%');
         }
         $posts=$posts->orderBy('menu_status','ASC')->paginate(30); 
        return view("seller.features.index",compact('posts','request'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         abort_if(!getpermission('products'),401);
        return view("seller.features.create");
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!getpermission('products'),401);
        $info=Category::where('type','product_feature')->findorFail($id);
        return view('seller.features.edit',compact('info'));
    }

    
}
