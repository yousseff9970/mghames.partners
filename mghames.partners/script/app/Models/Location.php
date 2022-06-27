<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
class Location extends Model
{
    use HasFactory;

    public function shipping()
    {
      return $this->belongsToMany(Category::class,'shippingcategories')->select('name','id','slug');
    }
    public function shippings()
    {
      return $this->belongsToMany(Category::class,'shippingcategories')->where('status',1)->select('name','id','slug','status');
    }
}
