<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Location;
use App\Models\Category;
use App\Models\User;

class Ordershipping extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'user_id',
        'location_id',
        'shipping_id',
        'shipping_driver',
        'shipping_price',
        'weight',
        'info',
        'lat',
        'long'
        
    ];

    public static function boot()
    {
      
        parent::boot();
        static::creating(function($model){
          
            $model->tracking_no=rand(1000,10000);
        });
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function shipping()
    {
       return $this->belongsTo(Category::class,'shipping_id','id');
    }

    public function rider()
    {
       return $this->belongsTo(User::class,'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id')->with('orderstatus');
    }

    public function orderdata()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'status_id','id');
    }
}
