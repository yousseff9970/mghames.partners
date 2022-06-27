<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Devicetoken extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'token',
        'is_mobile',
        'type',
        
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
