<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    public function getway()
    {
        return $this->belongsTo(Getway::class, 'gateway_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id')->select('id','name');
    }
}
