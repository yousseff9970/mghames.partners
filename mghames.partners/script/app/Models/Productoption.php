<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Price;
class Productoption extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'term_id',
        'category_id',
        'select_type',
        'is_required'
        
    ];

    public function category()
    {
        return $this->belongsTo(Category::class)->select('id','name','slug');
    }
    public function categorywithchild()
    {
        return $this->belongsTo(Category::class,'category_id')->with('categories');
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }
    public function priceswithcategories()
    {
        return $this->hasMany(Price::class)->with('category');
    }
}
