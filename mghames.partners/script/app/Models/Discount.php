<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Term;
class Discount extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'special_price',
        'price_type',
        'starting_date',
        'ending_date',
        'term_id'
        
    ];

    public function term()
    {
        return $this->belongsTo(Term::class,'term_id');
    }
}
