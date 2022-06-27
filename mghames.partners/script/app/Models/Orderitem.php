<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Term;
class Orderitem extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'term_id',
        'info',
        'qty',
        'amount',
    ];

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function termwithpreview()
    {
        return $this->belongsTo(Term::class,'term_id')->with('preview');
    }
    
}
