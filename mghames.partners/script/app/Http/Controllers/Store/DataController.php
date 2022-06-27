<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Term;
use App\Models\Review;
use App\Models\Price;
use Carbon\Carbon;
use Str;
class DataController extends Controller
{
    public function databack(Request $request)
    {
       foreach ($request->body as $key => $row) {
           $data[$key]=$this->$key($row);
       }
       return $data ?? [];
    }

    public function getData(Request $request)
    {
     
       foreach ($request->body as $key => $row) {
           $key=$row['key'];
           $data[$row['row']]=$this->$key($row);
       }

       
       return $data ?? [];
    }

    public function prices($types=[])
    {
        $max = $types['maxPrice'] ?? false;
        $min = $types['minPrice'] ?? false;


        if ($max != false) {
           $data['max']=Price::max('price');
        }
        if ($min != false) {
           $data['min']=Price::min('price');
        }

        return $data ?? [];

    }
    
    public function productmenu($types=[])
    {
        $limit = $types['limit'] ?? '-1';
        $with_child = $types['with_child'] ?? false;
        $withcount = $types['withcount'] ?? false;
        $orderby=$types['orderby'] ?? 'DESC';
        $type=$types['type'] ?? 'category';
        $with=$types['with'] ?? '';
        
        $categories=Category::query()->where('type',$type)->whereHas('termcategories')->where('status',1)->where('menu_status',1);
        $categories= $limit == '-1' ? $categories : $categories->take($limit);
        $categories= $with_child == false ? $categories : $categories->where('category_id',null)->with('childrenCategories');

        $categories=$orderby == 'ASC' ? $categories : $categories->latest();
        $categories= $with == '' ? $categories : $categories->with($with);

        $categories=$withcount != false ? $categories->withCount('termcategories') : $categories;

        return $categories->get(); 

    }

    public function categories($types=[])
    {
        $limit = $types['limit'] ?? '-1';
        $with_child = $types['with_child'] ?? false;
        $orderby=$types['orderby'] ?? 'DESC';
        $type=$types['type'] ?? 'category';
        $with=$types['with'] ?? '';
        $featured=$types['featured'] ?? false;
        $withcount = $types['withcount'] ?? false;
        
        $categories=Category::query()->where('type',$type)->where('status',1);
        $categories= $limit == '-1' ? $categories : $categories->take($limit);
        $categories= $with_child == false ? $categories : $categories->where('category_id',null)->with('childrenCategories');

        $categories=$featured == false ? $categories : $categories->where('featured',$featured);

        $categories= $orderby == 'ASC' ? $categories : $categories->latest();
        $categories= $withcount != false ? $categories->withCount('termcategories') : $categories;
        $categories= $with == '' ? $categories : $categories->with($with);
        return $categories->get(); 

    }

    public function brands($types=[])
    {
        $limit = $types['limit'] ?? '-1';
        $with_child = $types['with_child'] ?? false;
        $orderby=$types['orderby'] ?? 'DESC';
        $type=$types['type'] ?? 'brand';
        $with=$types['with'] ?? '';
        $withcount = $types['withcount'] ?? false;
        
        $categories=Category::query()->where('type',$type)->where('status',1);
        $categories= $limit == '-1' ? $categories : $categories->take($limit);
        $categories= $with_child == false ? $categories : $categories->where('category_id',null)->with('childrenCategories');

        $categories= $orderby == 'ASC' ? $categories : $categories->latest();
        $categories= $withcount != false ? $categories->withCount('termcategories') : $categories;
        $categories= $with == '' ? $categories : $categories->with($with);
        return $categories->get(); 

    }

    public function randomfeatures($types=[])
    {
        $limit = $types['limit'] ?? '-1';
        $with_child = $types['with_child'] ?? false;
        $orderby=$types['orderby'] ?? 'DESC';
        $type=$types['type'] ?? 'product_feature';
        $with=$types['with'] ?? '';
        $withcount = $types['withcount'] ?? false;
        $random=$types['random'] ?? false;

        $categories=Category::query()->where('type',$type)->where('status',1)->whereHas('termcategories')->select('id','name','type');
        $categories= $random != false ?  $categories->inRandomOrder() : $categories;
        $categories= $limit == '-1' ? $categories : $categories->take($limit);
        $categories= $with_child == false ? $categories : $categories->where('category_id',null)->with('childrenCategories');

        $categories= $orderby == 'ASC' ? $categories : $categories->latest();
        $categories= $withcount != false ? $categories->withCount('termcategories') : $categories;
        $categories= $with == '' ? $categories : $categories->with($with);
        return $categories->get(); 
    }

    public function productDetails($id)
    {
        $info=Term::query()->where('type','product')->with('tags','category','brands','excerpt','preview','optionwithcategories','price','firstprice','lastprice')->withCount('reviews')->findorfail($id);
        

        $data['data']=$info;

        $preview=asset($info->preview->value ?? 'uploads/default.png');
        $data['preview']=$preview;
        $galleries=[];
        
        array_push($galleries,$preview);

        

        $data['galleries']=$galleries;

        return response()->json($data);
    }

    public function storeratings($parm)
    {
       $reviews_count=Review::count();
       $avg_reviews=Review::avg('rating');

       $data['reviews_count']=$reviews_count;
       $data['avg_reviews']=(int)$avg_reviews;

       return $data;
    }

    public function heroslider($types=[])
    {
        $limit = $types['limit'] ?? '-1';
        $with_child = $types['with_child'] ?? false;
        $orderby=$types['orderby'] ?? 'DESC';
        $type=$types['type'] ?? 'slider';
        $with=$types['with'] ?? '';
        
        $categories=Category::query()->where('type',$type)->where('status',1);
        $categories= $limit == '-1' ? $categories : $categories->take($limit);
        $categories= $with_child == false ? $categories : $categories->where('category_id',null)->with('childrenCategories');

        $categories=$orderby == 'ASC' ? $categories : $categories->latest();
        $categories= $with == '' ? $categories : $categories->with($with);
        return $categories->get()->map(function ($q) use ($with)
        {
            $json=json_decode($q->slug ?? '');
            $data['title']=$q->name;
            $data['link']=url($json->link ?? '#');
            $data['button_text']=$json->button_text ?? '';
            if (in_array('description',$with)) {
               $data['description']=$q->description->content ?? '';
            }

            if (in_array('preview',$with)) {
               $data['preview']=$q->preview->content ?? '';
            }
            
            

            return $data;
        }); 
    }

    public function shortbanner($types=[])
    {
        $limit = $types['limit'] ?? '-1';
        $with_child = $types['with_child'] ?? false;
        $orderby=$types['orderby'] ?? 'DESC';
        $type=$types['type'] ?? 'short_banner';
        $with=$types['with'] ?? '';
        
        $categories=Category::query()->where('type',$type)->where('status',1);
        $categories= $limit == '-1' ? $categories : $categories->take($limit);
        $categories= $with_child == false ? $categories : $categories->where('category_id',null)->with('childrenCategories');

        $categories=$orderby == 'ASC' ? $categories : $categories->latest();
        $categories= $with == '' ? $categories : $categories->with($with);
        return $categories->get()->map(function ($q) use ($with)
        {
            $json=json_decode($q->slug ?? '');
            $data['title']=$q->name;
            $data['link']=url($json->link ?? '#');
            $data['button_text']=$json->button_text ?? '';
            if (in_array('description',$with)) {
               $data['description']=$q->description->content ?? '';
            }

            if (in_array('preview',$with)) {
               $data['preview']=$q->preview->content ?? '';
            }
            
            

            return $data;
        }); 
    }

     public function largebanner($types=[])
    {
        $limit = $types['limit'] ?? '-1';
        $with_child = $types['with_child'] ?? false;
        $orderby=$types['orderby'] ?? 'DESC';
        $type=$types['type'] ?? 'large_banner';
        $with=$types['with'] ?? '';
        
        $categories=Category::query()->where('type',$type)->where('status',1);
        $categories= $limit == '-1' ? $categories : $categories->take($limit);
        $categories= $with_child == false ? $categories : $categories->where('category_id',null)->with('childrenCategories');

        $categories=$orderby == 'ASC' ? $categories : $categories->latest();
        $categories= $with == '' ? $categories : $categories->with($with);
        return $categories->get()->map(function ($q) use ($with)
        {
            $json=json_decode($q->slug ?? '');
            $data['title']=$q->name;
            $data['link']=url($json->link ?? '#');
            $data['button_text']=$json->button_text ?? '';
            if (in_array('description',$with)) {
               $data['description']=$q->description->content ?? '';
            }

            if (in_array('preview',$with)) {
               $data['preview']=$q->preview->content ?? '';
            }
            
            

            return $data;
        }); 
    }

    public function menudays($types=[])
    {
        $limit = $types['limit'] ?? '-1';
        $with_child = $types['with_child'] ?? false;
        $orderby=$types['orderby'] ?? 'DESC';
        $type=$types['type'] ?? 'special_menu';
        $with=$types['with'] ?? '';
        
        $categories=Category::query()->where('type',$type)->where('status',1);
        $categories= $limit == '-1' ? $categories : $categories->take($limit);
        

        $categories=$categories->orderBy('featured','ASC');
        $categories= $with == '' ? $categories : $categories->with($with);
        return $categories->get()->map(function ($q) use ($with)
        {
            $json=json_decode($q->slug ?? '');
            $data['title']=$q->name;
            $data['days']=$json->days ?? '#';
            $data['time']=$json->time ?? '';
            $data['link']=url($json->link ?? '#');
            
            if (in_array('preview',$with)) {
               $data['preview']=$q->preview->content ?? '';
            }
            return $data;
        }); 
    }

    



    public function products($types=[])
    {
        
        $with_paginate = $types['with_paginate'] ?? false;
        $limit = $types['limit'] ?? 12;
        $with=$types['with'] ?? '';
        $orderby=$types['orderby'] ?? 'DESC';
        $is_random=$types['is_random'] ?? false;

        $products=Term::query()->where('type','product')->where('status',1)->with(['firstprice','lastprice'])->whereHas('firstprice');
        $products= $with == '' ? $products : $products->with($with);
        if ($is_random == false) {
            $products=$orderby == 'ASC' ? $products : $products->latest();
        }
        else{
             $products=$products->inRandomOrder();
        }
       
        $products=$with_paginate != false ? $products->paginate($limit) :  $products->take($limit)->get();

        return  $products;

    }

    public function HomePageFeaturedWithProducts($types = [])
    {
       $categories=Category::query()->where('type','product_feature')->where('featured',1)->whereHas('termcategories')->with('preview')->orderBy('menu_status','ASC')->get()->map(function ($q){
        $data['id']=$q->id;
        $data['name']=$q->name;
        $data['slug']=$q->slug;
        $data['preview']=asset($q->preview->content ?? 'uploads/default.png');
        return $data;
       });

       $cats_ids=[];
       $final_products=[];

       foreach ($categories as $key => $row) {
           $final_products[$row['id']]['preview']=$row['preview'];
           $final_products[$row['id']]['name']=$row['name'];
           $final_products[$row['id']]['slug']=$row['slug'];
           $final_products[$row['id']]['products']=[];
           
           
           array_push($cats_ids,$row['id']);
       }

       
        $limit = $types['product_limit'] ?? 12;
        $with=$types['product_with'] ?? '';
        $orderby=$types['orderby'] ?? 'DESC';
        $is_random=$types['is_product_random'] ?? false;

        $products=Term::query()->where('type','product')->where('status',1)->with(['firstprice','lastprice','termcategories'])->whereHas('firstprice');
         if (count($cats_ids ?? []) != 0) {
            $products=$products->whereHas('termcategories',function($q) use ($cats_ids) {
               return $q->whereIn('category_id',$cats_ids);
            });
        }

        $products= $with == '' ? $products : $products->with($with);
        if ($is_random != false) {
            $products=$products->inRandomOrder();
        }
        else{
            $products=$orderby == 'ASC' ? $products : $products->latest();
        }
        
       $products=$products->take($limit)->get();

       

        foreach ($products as $key => $value) {
           foreach($value->termcategories ?? [] as $r){
            if (in_array($r->category_id,$cats_ids)) {
               $final_products[$r->category_id]['products'][]=$value;
            }
           }
            
        }



        return $final_products;
    }

    public function topratedproducts($types=[])
    {
        
        
        $limit = $types['limit'] ?? 12;
        $with=$types['with'] ?? '';
        $orderby=$types['orderby'] ?? 'DESC';

        $products=Term::query()->where('type','product')->where('rating','!=',null)->where('status',1)->with(['firstprice','lastprice'])->whereHas('firstprice');
        $products= $with == '' ? $products : $products->with($with);
        $products=$products->withCount('reviews')->orderBy('reviews_count','DESC');
        $products= $products->take($limit)->get();

        return  $products;

    }

    public function getproducts(Request $request)
    {
       
        $with_paginate = (boolean)$request->with_paginate ?? false;
        $limit = $request->limit ?? 12;
        $with=$request->with ?? '';
        $orderby=$request->orderby ?? 'DESC';
        $random=$request->random ?? false;
        $hasdiscount=$request->hasdiscount ?? false;

        $products=Term::query()->where('type','product')->where('status',1)->with(['firstprice','lastprice'])->whereHas('firstprice');

        if (!empty($request->src)) {
           $products=$products->where('title','LIKE','%'.$request->src.'%');
        }

        if ($hasdiscount != false) {
           $products=$products->whereHas('discount',function($q){
            $q->where('ending_date','>=',now());
           });
        }

        $products= $with == '' ? $products : $products->with($with);
        if ($orderby == 'rating') {
            $products=$products->where('rating','!=',null)->withCount('reviews')->orderBy('reviews_count','DESC');
        }
        else{
            $products=$orderby == 'ASC' ? $products : $products->latest();
        }
        
        if (isset($request->minPrice)) {
            if (!empty($request->minPrice)) {
                $minPrice=$request->minPrice;
                $products=$products->whereHas('prices',function($q) use ($minPrice){
                   return $q->where('price','>=',$minPrice);
               });
            }
        }

        if (isset($request->maxPrice)) {
            if (!empty($request->maxPrice)) {
                $maxPrice=$request->maxPrice;
                $products=$products->whereHas('prices',function($q) use ($maxPrice){
                   return $q->where('price','<=',$maxPrice);
               });
            }
        }

        $products= $random != false ?  $products->inRandomOrder() : $products;
        if (count($request->categories ?? []) != 0) {
            $products=$products->whereHas('termcategories',function($q) use ($request) {
               return $q->whereIn('category_id',$request->categories);
            });
        }

        if (count($request->variations ?? []) != 0) {
            $products=$products->whereHas('prices',function($q) use ($request) {
               return $q->whereIn('category_id',$request->variations);
            });
        }
        $products=$with_paginate != false ? $products->paginate($limit) :  $products->take($limit)->get();

        return  $products;

    }

    public function getdiscountbleproducts($types=[])
    {
        $with_paginate = (boolean)$types['with_paginate'] ?? false;
        $limit = $types['limit'] ?? 12;
        $with=$types['with'] ?? '';
        $orderby=$types['orderby'] ?? 'DESC';

        $products=Term::query()->where('type','product')->where('status',1)->with(['firstprice','lastprice'])->whereHas('firstprice');
        $products= $with == '' ? $products : $products->with($with);
        $products=$orderby == 'ASC' ? $products : $products->latest();
        $products=$products->whereHas('discount');
        $products=$with_paginate == true || $with_paginate == 'true' ? $products->paginate($limit) :  $products->take($limit)->get();

        return  $products;
    }

    public function featuredAttributes($types=[])
    {
       

       return $posts=Category::where('type','parent_attribute')->where('featured',1)->whereHas('categories')->with('categories')->latest()->get()->map(function($q){
            $data['title']=$q->name;
            $data['id']=$q->id;
            $data['childs']=$q->categories->map(function($childs){
               $child['title']=$childs->name ?? '';
               $child['id']=$childs->id ?? '';
               return $child;
            });

            return $data;
       });

    }

    public function latestblogs($types=[])
    {
        
        $limit = $types['limit'] ?? 4;
        $with=$types['with'] ?? '';
        $orderby=$types['orderby'] ?? 'DESC';

        $products=Term::query()->where('type','blog')->where('status',1);
        $products= $with == '' ? $products : $products->with($with);
        $products=$orderby == 'ASC' ? $products : $products->latest();
        $products=$products->take($limit)->get()->map(function ($q) use ($with){
            $data['title']=Str::limit($q->title,40);
            $data['url']=url('/blog',$q->slug);
            $data['short_description']=Str::limit($q->excerpt->value ?? '',60);
            $data['preview']=asset($q->preview->value ?? 'uploads/default.png');
            $data['time']=Carbon::parse($q->updated_at)->format('d M, Y.');

            return $data;
        });

        return  $products;
    }

    public function getreviews($types=[])
    {

        $with_paginate = (boolean)$types['with_paginate'] ?? false;
        $limit = $types['limit'] ?? 12;
        $with=$types['with'] ?? '';
        $orderby=$types['orderby'] ?? 'DESC';
       

        $reviews=Review::query();
        $reviews= $with == '' ? $reviews : $reviews->with($with);
        $reviews=$orderby == 'ASC' ? $reviews : $reviews->latest();
        
        $reviews=$with_paginate == true || $with_paginate == 'true' ? $reviews->paginate($limit) :  $reviews->take($limit)->get();

        return $reviews;

    }

    public function getProductReviews($id)
    {
        return $reviews=Review::query()->where('term_id',$id)->latest()->whereHas('user')->with('user')->paginate(10)->through(fn ($q) => [
            'id' => $q->id,
            'comment' => $q->comment,
            'rating' => $q->rating,
            'username' => $q->user->name,

        ]);
    }

    public function productSearch(Request $request)
    {
        $value = $request->value;
        $products = Term::query()->where([
            ['title', 'LIKE', "%$value%"],
            ['type','product'],
            ['status',1]
        ])->with(['firstprice','lastprice','excerpt','preview','tags'])->whereHas('firstprice')->paginate(20);

        return response()->json($products);
    }
}
