<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
class Price extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $fillable = [
        'price',
        'term_id',
        'productoption_id',
        'category_id',
        'old_price',
        'qty',
        'sku',
        'weight',
        'stock_manage',
        'stock_status',
       
        
    ];

    public function category()
    {
        return $this->belongsTo(Category::class)->select('id','name');
    }
}
