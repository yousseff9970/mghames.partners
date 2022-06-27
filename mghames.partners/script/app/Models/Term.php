<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
use App\Models\Termmeta;
use App\Models\Termmedia;
use App\Models\Category;
use App\Models\Price;
use App\Models\Productoption;
use App\Models\Termcategory;
use App\Models\Discount;
use App\Models\Review;
use App\Models\Orderitem;

class Term extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_id',
    ];

    public static function boot()
    {
        parent::boot();
        if (tenant('id') != null) {
          
            static::creating(function($model){
                $model->id=Term::max('id') + 1;
                $model->full_id=str_pad($model->id, 7,'0',STR_PAD_LEFT);
            });
        }

       
    }

    // Relation To TermsMeta
    public function user()
    {
        return $this->belongsTo("App\Models\User", "featured", 'id');
    }

    public function termMeta()
    {
        return $this->hasOne(Termmeta::class, 'term_id')->where('key', 'service_meta');
    }

    public function quickStart()
    {
        return $this->hasOne(Termmeta::class, 'term_id')->where('key', 'quick_start_meta');
    }

    // Relation To TermsMeta
    public function page()
    {
        return $this->hasOne(Termmeta::class, 'term_id')->where('key', 'page');
    }

    // Relation To TermsMeta
    public function excerpt()
    {
        return $this->hasOne(Termmeta::class, 'term_id')->where('key', 'excerpt');
    }

    // Relation To TermsMeta
    public function thum_image()
    {
        return $this->hasOne(Termmeta::class, 'term_id')->where('key', 'thum_image');
    }

    // Relation To TermsMeta
    public function description()
    {
        return $this->hasOne(Termmeta::class, 'term_id')->where('key', 'description');
    }

    

    public function preview()
    {
        return $this->hasOne(Termmeta::class, 'term_id')->where('key', 'preview');
    }

    

    // Relation To TermsMeta
    public function meta()
    {
        return $this->hasOne(Termmeta::class, 'term_id');
    }
    public function media()
    {
        return $this->hasOne(Termmeta::class, 'term_id')->where('key', 'preview');
    }
    public function medias()
    {
        return $this->hasOne(Termmeta::class, 'term_id')->where('key', 'gallery');
    }
    public function seo()
    {
        return $this->hasOne(Termmeta::class, 'term_id')->where('key', 'seo');
    }
    public function discount()
    {
        return $this->hasOne(Discount::class, 'term_id');
    }

    public function price()
    {
        return $this->hasOne(Price::class, 'term_id')->where('productoption_id',null);
    }
    public function firstprice()
    {
        return $this->hasOne(Price::class, 'term_id');
    }
    public function lastprice()
    {
        return $this->hasOne(Price::class, 'term_id');
    }
    public function prices()
    {
        return $this->hasMany(Price::class, 'term_id');
    }
    public function categories()
    {
      return $this->belongsToMany(Category::class,'termcategories');
    }

     public function categorieswithone()
    {
      return $this->hasOne(Termcategory::class,'term_id');
    }

    public function tags()
    {
      return $this->belongsToMany(Category::class,'termcategories')->where('type','tag')->select('id','name','type','slug');
    }

    public function category()
    {
      return $this->belongsToMany(Category::class,'termcategories')->where('type','category')->select('id','name','type','slug');
    }

    public function brands()
    {
      return $this->belongsToMany(Category::class,'termcategories')->where('type','brand')->select('id','name','type','slug');
    }

    public function termcategories()
    {
      return $this->hasMany(Termcategory::class);
    }

    public function productoption()
    {
      return $this->hasMany(Productoption::class,'term_id');
    }

    public function reviews()
    {
      return $this->hasMany(Review::class,'term_id');
    }

    public function productoptionwithcategories()
    {
      return $this->hasMany(Productoption::class,'term_id')->with('categorywithchild','priceswithcategories');
    }

    public function optionwithcategories()
    {
      return $this->hasMany(Productoption::class,'term_id')->with('category','priceswithcategories');
    }

    public function orders()
    {
      return $this->hasMany(Orderitem::class,'term_id','id');
    }

    public function makeSlug($title,$type)
    {
       $slug_gen=Str::slug($title); 
       $slug=Term::where('type',$type)->where('slug',$slug_gen)->count();
       if ($slug > 0) {
          $slug_count=$slug+1;
          return $slug=$slug_gen.$slug_count;
          
       }

       return $slug_gen;
    }

    public function servicemeta()
    {
        return $this->hasOne('App\Models\Termmeta')->where('key','service')->select('id','term_id','value');
    }

    public function features()
    {
      return $this->belongsToMany(Category::class,'termcategories')->where('type','product_feature')->select('id','name','type','slug');
    }

    public function pagecontent()
    {
        return $this->hasOne('App\Models\Termmeta')->where('key','page')->select('id','term_id','value');
    }
    

}
