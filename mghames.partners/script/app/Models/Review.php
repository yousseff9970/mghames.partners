<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Review extends Model
{
    use HasFactory;

    public function user()
    {
       return $this->belongsTo(User::class,'user_id','id')->select('id','name');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id','id');
    }
}
