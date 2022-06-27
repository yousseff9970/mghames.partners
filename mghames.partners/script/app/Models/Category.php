<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorymeta;
use App\Models\Location;
use App\Models\Shippingcategory;
use App\Models\Order;
use App\Models\Termcategory;
use Str;
use Auth;


class Category extends Model
{
    use HasFactory;

    public function categories()
    {
      return $this->hasMany(Category::class,'category_id','id');
    }

    public function parent()
    {
      return $this->hasOne(Category::class,'id','category_id');
    }

    public function childrenCategories()
    {
      return $this->hasMany(Category::class,'category_id','id')->with('categories');
    }

    public function meta()
    {
      return $this->hasOne(Categorymeta::class);
    }

    public function description()
    {
    	return $this->hasOne(Categorymeta::class)->where('type','description');
    }

    public function preview()
    {
    	return $this->hasOne(Categorymeta::class)->where('type','preview');
    }

    public function locations()
    {
      return $this->belongsToMany(Location::class,'shippingcategories');
    }
    public function shippingcategoryrelations()
    {
       return $this->hasMany(Shippingcategory::class,);
    }

    public function icon()
    {
    	return $this->hasOne(Categorymeta::class)->where('type','icon');
    }

    public function makeSlug($title,$type)
    {
       $slug_gen=Str::slug($title); 
       $slug=Category::where('type',$type)->where('slug',$slug_gen)->count();
       if ($slug > 0) {
          $slug_count=$slug+1;
          $slug=$slug_gen.$slug_count;
          return $this->makeSlug($slug,$type);
       }

       return $slug_gen;
    }

    public function orderstatus()
    {
      return $this->hasMany(Order::class,'status_id','id');
    }

    public function terms()
    {
      return $this->belongsToMany(Term::class,Termcategory::class);
    }

    public function products()
    {
      return $this->belongsToMany(Term::class,Termcategory::class)->with('firstprice','lastprice','excerpt','tags','preview');
    }

    public function termcategories()
    {
      return $this->hasMany(Termcategory::class);
    }

}
