<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Termmedia extends Model
{
    use HasFactory;
     public $timestamps = false;
     protected $fillable = [
        'term_id',
        'value',
       
     ];
}
