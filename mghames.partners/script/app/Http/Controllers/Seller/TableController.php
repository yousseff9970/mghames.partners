<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       abort_if(!getpermission('website_settings'),401);
        $posts=Category::where('type','table')->with('preview');

        if (isset($request->src)) {
          $posts=  $posts->where('name','LIKE','%'.$request->src.'%');
        }
        $posts=$posts->latest()->paginate(20);
        return view('seller.table.index',compact('posts','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!getpermission('website_settings'),401);
        return view('seller.table.create');
    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         abort_if(!getpermission('website_settings'),401);
        $info=Category::where('type','table')->findorFail($id);
        return view('seller.table.edit',compact('info'));
    }

   
}
