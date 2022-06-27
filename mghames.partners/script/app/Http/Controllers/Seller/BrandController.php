<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Term;
use Str;
use DB;
use Milon\Barcode\DNS1D;
use Auth;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         abort_if(!getpermission('products'),401);
        $posts=Category::where('type','brand')->with('preview');

        if (isset($request->src)) {
          $posts=  $posts->where('name','LIKE','%'.$request->src.'%');
        }
        $posts=$posts->latest()->paginate(20);
        return view("seller.brand.index",compact('posts','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!getpermission('products'),401);
        return view("seller.brand.create");
    }

   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         abort_if(!getpermission('products'),401);
        return view("seller.brand.show");
    }


    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
         abort_if(!getpermission('products'),401);
        if(!$id) return back();
        $info=Category::with('description','preview','icon')->findorFail($id);
        return view("seller.brand.edit",compact('info'));
    }

    
}
