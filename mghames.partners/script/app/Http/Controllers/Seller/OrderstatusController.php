<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Str;
use DB;
use Auth;
class OrderstatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         abort_if(!getpermission('order'),401);
        $posts=Category::where('type','status');

        if (isset($request->src)) {
          $posts=  $posts->where('name','LIKE','%'.$request->src.'%');
        }
        $posts=$posts->orderBy('featured','ASC')->paginate(20);
        return view("seller.orderstatus.index",compact('posts','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!getpermission('order'),401);
        return view("seller.orderstatus.create");
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(!getpermission('order'),401);
        return view("seller.orderstatus.show");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!getpermission('order'),401);
        $info=Category::findorFail($id);
        return view("seller.orderstatus.edit",compact('info'));
    }

   
}
