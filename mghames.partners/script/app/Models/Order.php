<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guraded = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_no',
    ];

    public static function boot()
    {
      
        parent::boot();
        static::creating(function($model){
            $model->id=Order::max('id') + 1;
            $model->invoice_no=str_pad($model->id, 7,'0',STR_PAD_LEFT);
        });
        

    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function getway()
    {
        return $this->belongsTo(Getway::class, 'getway_id', 'id')->select('id','name');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select('id','name','email');
    }

    public function tenant()
    {
        return $this->hasOne('App\Models\Tenant');
    }

    public function ordermeta()
    {
        return $this->hasOne('App\Models\Ordermeta')->where('key','orderinfo');
    }
    
    public function meta()
    {
        return $this->hasOne('App\Models\Meta');
    }

    public function orderlog()
    {
       return $this->hasOne('App\Models\Tenantorder');
   }

   public function schedule()
   {
       return $this->hasOne('App\Models\Orderschedule');
   }

   public function orderitems()
   {
       return $this->hasMany('App\Models\Orderitem')->with('term');
   }

   public function orderitemswithpreview()
   {
       return $this->hasMany('App\Models\Orderitem')->with('termwithpreview');
   }

   public function reviews()
   {
       return $this->hasMany('App\Models\Review');
   }   
  
   public function ordertable()
   {
       return $this->belongsToMany(Category::class,'ordertables');
   }
   public function shipping()
   {
       return $this->hasOne(Ordershipping::class);
   }
   public function shippingwithinfo()
   {
       return $this->hasOne(Ordershipping::class)->with('location','shipping','rider');
   }
   public function orderstatus()
   {
       return $this->belongsTo(Category::class,'status_id')->select('id','name','slug');
   }

   public function orderstockitems()
   {
       return $this->hasMany(Orderstock::class);
   }

   
    
   




}
