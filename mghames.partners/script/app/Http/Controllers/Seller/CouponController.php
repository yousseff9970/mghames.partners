<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Auth;
class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!getpermission('products'),401);
        $posts=Coupon::latest();
        if (isset($request->src)) {
          $posts=  $posts->where('code','LIKE','%'.$request->src.'%');
        }
        $posts=$posts->paginate(30);
        return view("seller.coupon.index",compact('posts','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         abort_if(!getpermission('products'),401);
        return view("seller.coupon.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          abort_if(!getpermission('products'),401);
         if (postlimitcheck() == false) {
            $errors['errors']['error']='Maximum post limit exceeded';
            return response()->json($errors,401);
        }
        $validated = $request->validate([
         'coupon_code' => 'required|max:100',
         'price'=>'required|max:100',
         'start_from'=>'required|max:100',
         'will_expire'=>'required|max:100',
        ]);

        $coupon=new Coupon;
        $coupon->avatar=$request->preview ?? null;
        $coupon->code=$request->coupon_code;
        $coupon->value=$request->price;
        $coupon->is_percentage=$request->discount_type;
        $coupon->is_conditional=$request->is_conditional ?? 0;
        if ($request->is_conditional == 1) {
            $min_amount=$request->min_amount ?? 0;
        }
        else{
            $min_amount=0;
        }
        $coupon->min_amount=$min_amount;
        $coupon->start_from=$request->start_from ?? now();
        $coupon->will_expire=$request->will_expire;
        $coupon->is_featured=$request->is_featured;
        $coupon->status=$request->status;
        $coupon->save();

        return response()->json('Coupon Created Successfully...!!!');
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
        $info= Coupon::findorFail($id);
        return view("seller.coupon.edit",compact('info'));
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
         abort_if(!getpermission('products'),401);
       $validated = $request->validate([
         'coupon_code' => 'required|max:100',
         'price'=>'required|max:100',
         'start_from'=>'required|max:100',
         'will_expire'=>'required|max:100',
        ]);

        $coupon= Coupon::findorFail($id);
        $coupon->avatar=$request->preview ?? null;
        $coupon->code=$request->coupon_code;
        $coupon->value=$request->price;
        $coupon->is_percentage=$request->discount_type;
        $coupon->is_conditional=$request->is_conditional ?? 0;
         if ($request->is_conditional == 1) {
            $min_amount=$request->min_amount ?? 0;
        }
        else{
            $min_amount=0;
        }
        $coupon->min_amount=$min_amount;
        $coupon->start_from=$request->start_from ?? now();
        $coupon->will_expire=$request->will_expire;
        $coupon->is_featured=$request->is_featured;
        $coupon->status=$request->status;
        $coupon->save();

        return response()->json('Coupon Updated Successfully...!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         abort_if(!getpermission('products'),401);
        Coupon::destroy($id);

        return back();
    }
}
