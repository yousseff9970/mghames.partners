<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use DB;
use Str;
use Auth;
class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         abort_if(!getpermission('website_settings'),401);
        $posts=Location::latest();

        if (isset($request->src)) {
          $posts=  $posts->where('name','LIKE','%'.$request->src.'%');
        }
        $posts=$posts->paginate(20);
        return view("seller.location.index",compact('posts','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!getpermission('website_settings'),401);
        return view("seller.location.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         abort_if(!getpermission('website_settings'),401);
        
        if ((int)tenant('post_limit') != -1) {
             $count=postlimitcheck(false);
             $locations=Location::count();
             $count=$count+$locations;
             if ((int)tenant('post_limit') <= $count) {
                $errors['errors']['error']='Maximum post limit exceeded';
                return response()->json($errors,401);
            }
        }
        

        $request->validate([
            'name' => 'required|max:50',
            'lat' => 'max:50',
            'long' => 'max:50',
            'range' => 'max:50',
        ]);

        $location=new Location;
        $location->name=$request->name;
        $location->avatar=$request->preview ?? null;
        $location->slug=Str::slug($request->name);
        $location->lat=$request->lat;
        $location->long=$request->long;
        $location->range=$request->range;
        $location->featured=$request->featured ?? 0;
        $location->status=$request->status ?? 1;
        $location->save();

        return response()->json('Location Created....!!!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(!getpermission('website_settings'),401);
        return view("seller.location.show");
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
        $info=Location::findorFail($id);
        return view("seller.location.edit",compact('info'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(!getpermission('website_settings'),401);
        $request->validate([
            'name' => 'required|max:50',
            'lat' => 'max:50',
            'long' => 'max:50',
            'range' => 'max:50',
        ]);

        $location= Location::findorFail($id);
        $location->name=$request->name;
        $location->avatar=$request->preview ?? null;
        $location->slug=$request->slug;
        $location->lat=$request->lat;
        $location->long=$request->long;
        $location->range=$request->range;
        $location->featured=$request->featured ?? 0;
        $location->status=$request->status ?? 0;
        $location->save();

        return response()->json('Location updated....!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!getpermission('website_settings'),401);
         $category=Location::destroy($id);
         return back();
    }
}
