<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
	protected $table="post_category";
	protected $fillable = [
		'term_id','category_id'
	];
	public $timestamps = false;

	public function category()
	{
		return $this->hasOne('App\Category','id','category_id')->select('id','name','slug');
	}
}
