<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shippingcategory;
use App\Models\Category;
use App\Models\Location;
use DB;
use Auth;
class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!getpermission('website_settings'),401);
        $posts=Category::where('type','shipping')->with('locations','preview');
        if ($request->src) {
            $posts=$posts->where('name','LIKE','%'.$request->src.'%');
        }
         $posts=$posts->latest()->paginate(30); 
        return view("seller.shipping.index",compact('posts','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         abort_if(!getpermission('website_settings'),401);
        $posts=Location::where('status',1)->latest()->get();
        return view("seller.shipping.create",compact('posts'));
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
         $validatedData = $request->validate([
            'name' => 'required|max:50',
            'price' => 'required|max:50',
            'locations' => 'required',
       
         ]);
         if (postlimitcheck() == false) {
            $errors['errors']['error']='Maximum post limit exceeded';
            return response()->json($errors,401);
        }

        DB::beginTransaction();
        try {  
        $shipping=new Category;
        $shipping->name=$request->name;
        $shipping->slug=$request->price;
        $shipping->type="shipping";
        $shipping->save();

        if ($request->preview) {
               $shipping->meta()->create(['type'=>'preview','content'=>$request->preview]);
        }

        $shipping->locations()->attach($request->locations);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
            $errors['errors']['error']='Opps something wrong';
            return response()->json($errors,401);
        }    

       return response()->json('Shipping Method Created....!!!');
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
        $info= Category::where('type','shipping')->with('shippingcategoryrelations')->findorFail($id);
        $posts=Location::where('status',1)->latest()->get();
        $location_array=[];

        foreach ($info->shippingcategoryrelations as $key => $value) {
           array_push($location_array, $value->location_id);
        }

        return view("seller.shipping.edit",compact('info','posts','location_array'));
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
        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'price' => 'required|max:50',
            'locations' => 'required',
       
         ]);

        DB::beginTransaction();
        try {  
        $shipping= Category::findorFail($id);
        $shipping->name=$request->name;
        $shipping->slug=$request->price;
        $shipping->status=$request->status;
        $shipping->save();

         if ($request->preview) {
                if (empty($shipping->preview)) {
                     $shipping->preview()->create(['type'=>'preview','content'=>$request->description]);
                }
                else{
                    $shipping->preview()->update(['content'=>$request->preview]);
                }
             
            }
            else{
               if (!empty($shipping->preview)) {
                $shipping->preview()->delete();
               } 
            }

        $shipping->locations()->sync($request->locations);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
            $errors['errors']['error']='Opps something wrong';
            return response()->json($errors,401);
        }    

        return response()->json('Shipping Method Updated....!!!');

    }

   
}
