<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Term;
use App\Models\Price;
use App\Models\Productoption;
use DB;
use DNS1D;
use DNS2D;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use Auth;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!getpermission('products'),401);
        $posts=Term::query()->where('type','product')->with('media','price')->withCount('orders');
        if (!empty($request->src) && !empty($request->type)) {
           $posts=$posts->where($request->type,'LIKE','%'.$request->src.'%');
        }
        $posts=$posts->latest()->paginate(20);

        $type= $request->type ?? '';
       
        return view("seller.product.index",compact('posts','request','type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!getpermission('products'),401);
         $attributes=Category::query()->where('type','parent_attribute')->with('categories')->latest()->get();
         $features=Category::query()->where('type','product_feature')->orderBy('menu_status','ASC')->get();
         
        return view("seller.product.create",compact('attributes','features'));
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
            $errors['errors']['error']='Maximum product limit exceeded';
            return response()->json($errors,401);
        }

        $validated = $request->validate([
            'name' => 'required|max:100',
            'short_description' => 'max:500',
        ]);

        if ($request->product_type != 1) {
             $validated = $request->validate([
                'price' => 'required|max:100',
             ]);
        }
        else{
            $validated = $request->validate([
                'childattribute' => 'required',
             ]);
        }

      
        DB::beginTransaction();
        try { 
        $term=new Term;
        $term->title=$request->name;
        $term->slug=$term->makeSlug($request->name,'product');
        $term->type='product';
        $term->status=$request->status;
        $term->is_variation=$request->product_type;
        $term->save();

       if ($request->short_description) {
           $term->meta()->create(['key'=>'excerpt','value'=>$request->short_description]);
       }

        if ($request->preview) {
           $term->meta()->create(['key'=>'preview','value'=>$request->preview]);
        }

        if ($request->categories) {
            $term->categories()->attach($request->categories);
        }

       if ($request->product_type != 1) {
           $term->price()->create([
            'price'=>$request->price,
            'qty'=>$request->qty,
            'sku'=>$request->sku,
            'weight'=>$request->weight,
            'stock_manage'=>$request->stock_manage,
            'stock_status'=>$request->stock_status
          ]);
        }
        else{
            $productoptions=[];
            foreach ($request->childattribute['options'] ?? [] as $key => $value) {
              if (isset($request->childattribute['priceoption'][$key])) {
               $group= $term->productoption()->create(['category_id'=>$key,'select_type'=>$value['select_type'],'is_required'=>$value['is_required']]);
                
                foreach($request->childattribute['priceoption'][$key] ?? [] as $k => $row){ 
                   
                    $data['term_id']=$term->id;
                    $data['price']=$row['price'] ?? 0;
                    $data['qty']=$row['qty'] ?? 0;
                    $data['sku']=$row['sku'] ?? 0;
                    $data['weight']=$row['weight'] ?? 0;
                    $data['productoption_id']=$group->id;
                    $data['stock_manage']=$row['stock_manage'] ?? 0;
                    $data['stock_status']=$row['stock_status'] ?? 0;
                    $data['category_id']=$k;

                    array_push($productoptions,$data);
                }
               
              }
              
             
            }
            if (count($productoptions) > 0) {
              $term->prices()->insert($productoptions);
            }

        }

        DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            
            $errors['errors']['error']='Opps something wrong';
            return response()->json($errors,401);
        } 
        
        


        return response()->json(['Product Created']);


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
        return view("seller.product.show");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$type="general")
    {
        abort_if(!getpermission('products'),401);
        if ($type == 'general') {
            $info=Term::query()->where('type','product')->with('tags','excerpt','description','termcategories')->findorFail($id);
            $selected_categories=[];

            foreach ($info->termcategories as $key => $value) {
                
                array_push($selected_categories,$value->category_id);
            }
            $features=Category::query()->where('type','product_feature')->orderBy('menu_status','ASC')->get();

            return view("seller.product.edit",compact('info','selected_categories','features','id'));
        }

        if ($type == 'price') {
            $info=Term::query()->where('type','product')->with('price','productoptionwithcategories')->findorFail($id);
            $attributes=Category::query()->where('type','parent_attribute')->with('categories')->latest()->get();
            return view("seller.product.price",compact('info','id','attributes'));
        }

       if ($type == 'image') {
            $info=Term::query()->where('type','product')->with('media','medias')->findorFail($id);
            $medias=json_decode($info->medias->value ?? '');
          
            return view("seller.product.image",compact('info','id','medias'));
       }

       if ($type == "seo") {
            $info=Term::query()->where('type','product')->with('seo')->findorFail($id);
            $seo=json_decode($info->seo->value ?? '');
      
           return view("seller.product.seo",compact('info','id','seo'));
       }

       if($type == "discount"){
            $info=Term::query()->where('type','product')->with('discount')->findorFail($id);
            return view("seller.product.discount",compact('info','id'));
       }
       if($type == "barcode"){
            abort_if(tenant('barcode') != 'on',401);
            $info=Term::query()->where('type','product')->with('preview')->findorFail($id);
            return view("seller.product.product_based_barcode",compact('info','id'));
       }

        if($type == "express-checkout"){
            $info=Term::query()->where('type','product')->with('price','productoptionwithcategories')->findorFail($id);
            return view("seller.product.express_checkout",compact('info','id'));
       }
        
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
        if ($request->type == 'general') {
           $validated = $request->validate([
            'name' => 'required|max:100',
            'slug' => 'required|max:100',
            'short_description' => 'max:500',
            'long_description' => 'max:10000',
            ]);
           

        DB::beginTransaction();
            try { 
            $term=Term::where('type','product')->with('excerpt','description','termcategories')->findorFail($id);
            $term->title=$request->name;
            $term->slug=$request->slug;
            $term->status=$request->status;
            $term->featured=$request->featured;
            $term->save();

            if ($request->short_description) {
                if (empty($term->excerpt)) {
                     $term->excerpt()->create(['key'=>'excerpt','value'=>$request->short_description]);
                }
                else{
                    $term->excerpt()->update(['value'=>$request->short_description]);
                }
             
            }
            else{
               if (!empty($term->excerpt)) {
                $term->excerpt()->delete();
               } 
            }

            if ($request->long_description) {
                if (empty($term->description)) {
                     $term->description()->create(['key'=>'description','value'=>$request->long_description]);
                }
                else{
                    $term->description()->update(['value'=>$request->long_description]);
                }
             
            }
            else{
               if (!empty($term->description)) {
                $term->description()->delete();
               } 
            }

            $cats=[];
            foreach($request->categories ?? [] as $r){
                if (!empty($r)) {
                   array_push($cats,$r);
                }
                
            }

            !empty($term->categories) ? $term->categories()->sync($cats) : $term->categories()->attach($cats);
            
            
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                return $th;
                $errors['errors']['error']='Opps something wrong';
                return response()->json($errors,401);
            } 

            return response()->json('Product Information Updated...!!');

       }

       if ($request->type == 'price') {
        
          DB::beginTransaction();
          try { 

       if ($request->product_type != 1) {
           $term=Term::where('type','product')->with('price')->findorFail($id);
           $term->is_variation=$request->product_type;
           $term->save();  
           //single price
           if (empty($term->price)) {
               $term->price()->create(['price'=>$request->price,'qty'=>$request->qty,'sku'=>$request->sku,'weight'=>$request->weight,'stock_manage'=> $request->stock_manage,'stock_status'=> $request->stock_status]);
           }
           else{
            $term->price()->update(['price'=>$request->price,'qty'=>$request->qty,'sku'=>$request->sku,'weight'=>$request->weight,'stock_manage'=> $request->stock_manage,'stock_status'=> $request->stock_status]);
           }
           //end single price
         }
         else{
            $term=Term::where('type','product')->with('productoption','prices')->findorFail($id);
             $term->is_variation=$request->product_type;
             $term->save();  
           
            $updated_option_group=[];
            $updated_child_row=[];


            foreach($request->childattribute['child'] ?? [] as $keychild => $child){
                array_push($updated_option_group,$keychild);
                $group=Productoption::where('id',$keychild)->first();
                $group->update(['select_type'=>$child['select_type'],'is_required'=>$child['is_required']]);
            }

            foreach($request->childattribute['priceoption'] ?? [] as $optionkey => $priceoption){
                array_push($updated_child_row,$optionkey);

                Price::where('id',$optionkey)->update([
                    'price'=>$priceoption['price'],
                    'qty'=>$priceoption['qty'],
                    'sku'=>$priceoption['sku'],
                    'weight'=>$priceoption['weight'],
                    'stock_manage'=>$priceoption['stock_manage'],
                    'stock_status'=>$priceoption['stock_status']

                ]);

            }
            
            //delete row
            $deleteable_option=[];
            $deleteable_prices=[];
            foreach($term->productoption ?? [] as $row){
                if (in_array($row->id,$updated_option_group) == false) {
                    array_push($deleteable_option,$row->id);
                }
            }

            foreach($term->prices ?? [] as $row){
                if (in_array($row->id,$updated_child_row) == false) {
                    array_push($deleteable_prices,$row->id);
                }
            }

            if (count($deleteable_option) > 0) {
               Productoption::whereIn('id',$deleteable_option)->delete();
            }
            
            if (count($deleteable_prices) > 0) {
                Price::whereIn('id',$deleteable_prices)->delete();
            }
            
            
           
            
            


            //insert new row
            $productoptions=[];
            foreach ($request->childattribute['new_priceoption'] ?? [] as $key => $value) {
              if (isset($request->childattribute['new_priceoption'][$key])) {
              
                
                foreach($request->childattribute['new_priceoption'][$key] ?? [] as $k => $row){ 
                   
                    $data['term_id']=$term->id;
                    $data['price']=$row['price'] ?? 0;
                    $data['qty']=$row['qty'] ?? 0;
                    $data['sku']=$row['sku'] ?? 0;
                    $data['weight']=$row['weight'] ?? 0;
                    $data['productoption_id']=$key;
                    $data['stock_manage']=$row['stock_manage'] ?? 0;
                    $data['stock_status']=$row['stock_status'] ?? 0;
                    $data['category_id']=$k;

                    array_push($productoptions,$data);
                }
               
              }
              
             
            }
            

            if(isset($request->childattribute['new_child_group'])){
            foreach ($request->childattribute['new_child_group'] ?? [] as $childkey => $child) {
               $group= $term->productoption()->create(['category_id'=>$childkey,'select_type'=>$child['select_type'],'is_required'=>$child['is_required']]);
                
                foreach($child['childrens'] ?? [] as $key => $child_row){ 
                   
                    $data['term_id']=$term->id;
                    $data['price']=$child_row['price'] ?? 0;
                    $data['qty']=$child_row['qty'] ?? 0;
                    $data['sku']=$child_row['sku'] ?? 0;
                    $data['weight']=$child_row['weight'] ?? 0;
                    $data['productoption_id']=$group->id;
                    $data['stock_manage']=$child_row['stock_manage'] ?? 0;
                    $data['stock_status']=$child_row['stock_status'] ?? 0;
                    $data['category_id']=$key;

                    array_push($productoptions,$data);
                }
            }
           }


            if (count($productoptions) > 0) {
                  $term->prices()->insert($productoptions);
            }

        }  
          
                
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            $errors['errors']['error']='Opps something wrong';
            return response()->json($errors,401);
        }    
         return response()->json('Product Price Updated...!!');
       }


       if ($request->type == 'images') {
             DB::beginTransaction();
             try { 

           $term=Term::where('type','product')->with('media','medias')->findorFail($id);
           if ($request->preview) {
                if (empty($term->media)) {
                     $term->media()->create(['key'=>'preview','value'=>$request->preview]);
                }
                else{
                    $term->media()->update(['value'=>$request->preview]);
                }
             
            }
            else{
               if (!empty($term->description)) {
                $term->media()->delete();
               } 
            }

            if ($request->multi_images) {
                if (empty($term->medias)) {
                     $term->medias()->create(['key'=>'gallery','value'=>json_encode($request->multi_images)]);
                }
                else{
                    $term->medias()->update(['value'=>json_encode($request->multi_images)]);
                }
             
            }
            else{
               if (!empty($term->description)) {
                $term->medias()->delete();
               } 
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            $errors['errors']['error']='Opps something wrong';
            return response()->json($errors,401);
        } 


         return response()->json('Product Image Updated...!!');   
       }


      if ($request->type == 'seo') {
         DB::beginTransaction();
        try { 
        $term=Term::where('type','product')->with('seo')->findorFail($id);
        
        $data['preview']=$request->preview;
        $data['title']=$request->title;
        $data['tags']=$request->tags;
        $data['description']=$request->description;


         if (empty($term->seo)) {
            $term->seo()->create(['key'=>'seo','value'=>json_encode($data)]);
         }
         else{
           $term->seo()->update(['value'=>json_encode($data)]);
        }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            $errors['errors']['error']='Opps something wrong';
            return response()->json($errors,401);
        } 
            
        return response()->json('Product Seo Updated...!!');  
      }

      if ($request->type == 'discount') {
      //  dd($request->all());

         DB::beginTransaction();
        try { 
            $term=Term::where('type','product')->with('discount','prices')->findorFail($id);
            if (empty($term->discount)) {
                $term->discount()->create(['special_price'=>$request->special_price,'price_type'=>$request->price_type,'ending_date'=>$request->ending_date]);
            }
            else{
                $term->discount()->update(['special_price'=>$request->special_price,'price_type'=>$request->price_type,'ending_date'=>$request->ending_date]);
            }
           
           
              foreach ($term->prices as $key => $row) {
                    $price=Price::find($row->id);
                    $current_price=!empty($price->old_price) ? $price->old_price : $price->price;

                    if ($request->price_type == 1) {
                        $percentage=$current_price * $request->special_price / 100;
                        $new_price=$current_price-$percentage;
                    }
                    else{
                        $new_price=$current_price-$request->special_price;
                    }

                    $price->price=$new_price;
                    $price->old_price=$current_price;
                    $price->save();
                }
            
           
                
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            $errors['errors']['error']='Opps something wrong';
            return response()->json($errors,401);
        } 

         return response()->json('Product Discount Applied...!!');  
            
      }

      if ($request->type == 'barcode') {
         $term=Term::where('type','product')->with('discount','prices')->findorFail($id);
         if ($request->barcode_type == 'QRCODE' || $request->barcode_type == 'PDF417') {
             $barcode=DNS2D::getBarcodePNG($term->full_id, $request->barcode_type);
         }
         else{
            $barcode= DNS1D::getBarcodePNG($term->full_id, $request->barcode_type);
         }
         
         
         return response()->json(['barcode'=>$barcode]);
      }

      


    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function multiDelete(Request $request)
    {
     abort_if(!getpermission('products'),401);
      if ($request->ids) {
        if ($request->method=='delete') {
            Term::query()->where('type','product')->where('id',$request->ids)->delete();  

            return response()->json('Successfully Product Deleted...!!!');
        }
        else{
            foreach ($request->ids as $id) {
                
              $product= Term::where('type','product')->find($id);
               if (!empty($product)) {
                 $product->status=$request->method;
                 $product->save();   
               }
            }
            return response()->json('Successfully Product Deleted...!!!');
        }
        
       }

      return response()->json('Select Some product...!!!');

    }

    public function import(Request $request)
    {
       abort_if(!getpermission('products'),401);
        $request->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls|max:2048'
        ]);

        Excel::import(new ProductImport,  $request->file('file'));

        return response()->json(['Product Imported Successfully']);
    }
}
