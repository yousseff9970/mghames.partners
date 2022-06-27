<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Term;
use App\Models\Productoption;
use Carbon\Carbon;
use Cart;
use DB;
use App\Models\Coupon;


class CartController extends Controller
{
    

    public function addtowishlist(Request $request){
        $getrowid=$request->getrowid ?? false;

        $info=Term::query()->where('type','product')->with('preview','firstprice')->where('status',1)->findOrFail($request->id);
        $price=$info->firstprice;
        $weight=$price->weight ?? 0;
        $options=[
                
                'sku'=>$price->sku,
                'stock'=>$price->qty,
                'options'=>[],
                'preview'=>asset($info->preview->value ?? 'uploads/default.png'),
                'slug'=>$info->slug
               
            ];

            

        if ($price->stock_manage == 1 && $price->stock_status == 1) {
           $options['stock']=$price->qty;
        }
        else{
           $options['stock']=null;
        }


        $cart=Cart::instance('wishlist')->add(['id' => $info->id, 'name' => $info->title, 'qty' => 1, 'price' => $price->price, 'weight' => 0, 'options' => $options]);
        $count=Cart::instance('wishlist')->count();

        if ($getrowid != false) {
           $data['rowid']=$cart->rowId ?? '';
           $data['count']=$count ?? 0;

           return $data;
        }


        return $count;
    }

    public function makediscount(Request $request)
    {
        if (Cart::count() == 0) {
             $errors['errors']['error']='Please add some product in your cart';
             return response()->json($errors,401);
        }
        $validated = $request->validate([
          'coupon'=>'required|max:100'
        ]);
        $total_amount=str_replace(',','',Cart::total());
        $total_discount=str_replace(',','',Cart::discount());
        $mydate= Carbon::now()->toDateString();
        $coupon=Coupon::where('code',$request->coupon)
                    ->where('start_from','<=',$mydate)
                    ->where('will_expire','>=',$mydate)
                    ->where('status',1)
                    ->latest()
                    ->first();
        if ($coupon == null) {
             $errors['errors']['error']='Opps this coupon is not available...';
             return response()->json($errors,401);
        }

        if ($coupon->is_conditional == 1) {
                
            if ($total_amount < $coupon->min_amount) {
                $errors['errors']['error']='The minumum order amount is '.number_format($coupon->min_amount,2).' for this coupon';
                    return response()->json($errors,401);
           }

        }

        if ($coupon->is_percentage == 0) {
            $total_amount=$total_amount-$coupon->value;
            $total_discount=$coupon->value;

            $total=str_replace(',','',Cart::total());
            $flat_discount=$coupon->value;
            $percent=($flat_discount*100)/$total;
            
            Cart::setGlobalDiscount($percent);
        }
        else{
            Cart::setGlobalDiscount($coupon->value);
             
        }


        return response()->json('Coupon Applied');
    }

    public function express(Request $request)
    {
        
       if ($request->qty == 0) {
           $errors['errors']['error']='Minimum cart quantity 1';
           return response()->json($errors,401);
       }
        
        if ($request->term) {
            $info=Term::query()->where('type','product')->with('preview')->where('status',1)->findOrFail($request->term);
        }
        
        
        if ($info->is_variation == 1) {
                $groups=[];
                foreach ($request->option ?? [] as $key => $option) {
                    $option_values=[];
                    foreach ($option as $k => $value) {
                    array_push($option_values,$value);
                    }
                    
                    $group=Productoption::with(array('priceswithcategories'=>function($query) use ($option_values){
                            return $query->whereIn('id',$option_values);
                    }))->with('category')->where('id',$key)->first();

                    array_push($groups,$group);
                     
                 }
                   
                $final_price=0;
                $final_weight=0;   
                $price_option=[];
                $stock_status=true;
                $stock_limit=true;
                $priceids=[];
                foreach($groups as $mainid => $row){
                   
                    
                    foreach ($row->priceswithcategories as $key => $value) {
                        if ($value->stock_status == 0) {
                            $stock_status=false;
                        }
                        if ($value->stock_manage == 1) {
                            if ($value->qty < $request->qty) {
                               $stock_limit=false;
                            }

                            array_push($priceids,$value->id);
                        }
                        $final_price=$final_price+$value->price;
                        $final_weight=$final_weight+$value->weight;

                        $price_option[$row->category->name][$value->id]['price']=$value->price;
                        $price_option[$row->category->name][$value->id]['sku']=$value->sku;
                        $price_option[$row->category->name][$value->id]['weight']=$value->weight;
                        $price_option[$row->category->name][$value->id]['name']=$value->category->name;
                        $price_option[$row->category->name][$value->id]['price_id']=$value->id;
                         
                        
                    }
                }

                if ($final_price == 0) {
                    $errors['errors']['error']='Select a required variation';
                    return response()->json($errors,401);
                }

                if ($stock_status == false) {
                    $errors['errors']['error']='Stock Out';
                    return response()->json($errors,401);
                }

                 if ($stock_limit == false) {
                    $errors['errors']['error']='Maximum stock limit exceeded';
                    return response()->json($errors,401);
                }

                Cart::add(['id' => $info->id, 'name' => $info->title, 'qty' => $request->qty, 'price' => $final_price, 'weight' => $final_weight, 'options' => [
                    'options'=>$price_option,
                    'sku'=>null,
                    'stock'=>null,
                    'preview'=>asset($info->preview->value ?? 'uploads/default.png'),
                    'slug'=>$info->slug,
                    'price_id'=>$priceids
                ]]);
               
                
        }
        else{
            $price=$info->firstprice;
            $weight=$price->weight ?? 0;
            
            $options=[
                
                'sku'=>$price->sku,
                'stock'=>$price->qty,
                'options'=>[],
                'preview'=>asset($info->preview->value ?? 'uploads/default.png'),
                'slug'=>$info->slug,
                
               
            ];

            

            if ($price->stock_manage == 1 && $price->stock_status == 1) {
               $options['stock']    = $price->qty;
               $options['price_id'] = [$price->id];
            }
            else{
               $options['stock']=null;
            }

            Cart::add(['id' => $info->id, 'name' => $info->title, 'qty' => $request->qty, 'price' => $price->price, 'weight' => $weight, 'options' => $options]);
        }

       
        return redirect('/checkout');
        
    }

    public function addtocart(Request $request)
    {
        
       if ($request->qty == 0) {
           $errors['errors']['error']='Minimum cart quantity 1';
            return response()->json($errors,401);
       }
        
        if ($request->id) {
            $info=Term::query()->where('type','product')->with('preview')->where('status',1)->findOrFail($request->id);
        }
        
        
        if ($info->is_variation == 1) {



                $groups=[];
                foreach ($request->option ?? [] as $key => $option) {
                    $option_values=[];
                    foreach ($option as $k => $value) {
                    array_push($option_values,$value);
                    }
                    
                    $group=Productoption::with(array('priceswithcategories'=>function($query) use ($option_values){
                            return $query->whereIn('id',$option_values);
                    }))->with('category')->where('id',$key)->first();

                    array_push($groups,$group);
                     
                 }
                   
                $final_price=0;
                $final_weight=0;   
                $price_option=[];
                $stock_status=true;
                $stock_limit=true;
                $priceids=[];
                foreach($groups as $mainid => $row){
                   
                    
                    foreach ($row->priceswithcategories as $key => $value) {
                        if ($value->stock_status == 0) {
                            $stock_status=false;
                        }
                        if ($value->stock_manage == 1) {
                            if ($value->qty < $request->qty) {
                               $stock_limit=false;
                            }

                            array_push($priceids,$value->id);
                        }
                        $final_price=$final_price+$value->price;
                        $final_weight=$final_weight+$value->weight;

                        $price_option[$row->category->name][$value->id]['price']=$value->price;
                        $price_option[$row->category->name][$value->id]['sku']=$value->sku;
                        $price_option[$row->category->name][$value->id]['weight']=$value->weight;
                        $price_option[$row->category->name][$value->id]['name']=$value->category->name;
                        $price_option[$row->category->name][$value->id]['price_id']=$value->id;
                         
                        
                    }
                }

                if ($final_price == 0) {
                    $errors['errors']['error']='Select a required variation';
                    return response()->json($errors,401);
                }

                if ($stock_status == false) {
                    $errors['errors']['error']='Stock Out';
                    return response()->json($errors,401);
                }

                 if ($stock_limit == false) {
                    $errors['errors']['error']='Maximum stock limit exceeded';
                    return response()->json($errors,401);
                }

                Cart::add(['id' => $info->id, 'name' => $info->title, 'qty' => $request->qty, 'price' => $final_price, 'weight' => $final_weight, 'options' => [
                    'options'=>$price_option,
                    'sku'=>null,
                    'stock'=>null,
                    'preview'=>asset($info->preview->value ?? 'uploads/default.png'),
                    'slug'=>$info->slug,
                    'price_id'=>$priceids
                ]]);
               
                
        }
        else{
            $cart_content=Cart::instance('default')->content();
                
            $exist_qty=0;

            foreach ($cart_content as $key => $row) {
               if ($row->id == $info->id) {
                   $row_qty=$row->qty ?? 0;
                   $exist_qty=(int)$row_qty;
               }
            }

            $exist_qty=$exist_qty+$request->qty;

            


            $price=$info->firstprice;
            $weight=$price->weight ?? 0;

            if ($price->stock_manage == 1) {
                if ($exist_qty >= $price->qty) {
                    $errors['errors']['error']='Maximum stock limit is ('.$price->qty.')';
                    return response()->json($errors,401);
                }
            }
            
            $options=[
                
                'sku'=>$price->sku,
                'stock'=>$price->qty,
                'options'=>[],
                'preview'=>asset($info->preview->value ?? 'uploads/default.png'),
                'slug'=>$info->slug,
                
               
            ];

            

            if ($price->stock_manage == 1 && $price->stock_status == 1) {
               $options['stock']    = $price->qty;
               $options['price_id'] = [$price->id];
            }
            
            if ($price->stock_status == 0) {
                $errors['errors']['error']='Opps Maximum stock limit exceeded';
                return response()->json($errors,401);
                
            }

            Cart::add(['id' => $info->id, 'name' => $info->title, 'qty' => $request->qty, 'price' => $price->price, 'weight' => $weight, 'options' => $options]);
        }

        $productcartdata['cart_content']=Cart::content();
        $productcartdata['cart_subtotal']=Cart::subtotal();
        $productcartdata['cart_tax']= Cart::tax();
        $productcartdata['cart_total']= Cart::total();
        $productcartdata['cart_count']= Cart::count();
        return response()->json($productcartdata);
        
    }




    public function removecart($id)
    {
        Cart::remove($id);
        $productcartdata['cart_subtotal']=Cart::subtotal();
        $productcartdata['cart_tax']= Cart::tax();
        $productcartdata['cart_total']= Cart::total();
        $productcartdata['cart_count']= Cart::count();
        return response()->json($productcartdata);
    }

    public function removeWishlist(Request $request,$id)
    {
       Cart::instance('wishlist')->remove($id);
       if ($request->ajax()) {
           return Cart::count();
       }
       return back();
    }

    public function CartQty(Request $request)
    {
        Cart::update($request->id, $request->qty);
        $productcartdata['cart_subtotal']=Cart::subtotal();
        $productcartdata['cart_tax']= Cart::tax();
        $productcartdata['cart_total']= Cart::total();
        $productcartdata['cart_count']= Cart::count();
        return response()->json($productcartdata);
    }

    public function varidation($id)
    {
         $info=Term::query()->where('type','product')->with('productoptionwithcategories')->findorFail($id);
         return response()->json($info);
    }

}
