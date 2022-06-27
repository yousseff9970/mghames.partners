<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Terms extends Model
{

	protected $table="terms";
	public $lebel_id=1;


	public function meta()
	{
		return 	$this->hasOne('App\Meta','term_id','id');
	}

	public function floor_plans()
	{
		return 	$this->hasMany('App\Meta','term_id','id')->where('type','floor_plan');
	}

	

	public function post_preview()
    {
        return $this->hasOne('App\Models\Mediapost','term_id')->with('media');
    }

	
	public function categories()
	{
		return $this->belongsToMany('App\Category','post_category','term_id','category_id');
	}

	public function category()
	{
		return $this->hasOne('App\PostCategory','term_id')->where('type','category');
	}

	public function property_type()
	{
		return $this->hasOne('App\PostCategory','term_id')->where('type','category')->with('category');
	}
	public function property_status_type()
	{
		return $this->hasOne('App\PostCategory','term_id')->where('type','status')->with('category');
	}

	public function post_city()
	{
		return $this->hasOne('App\Models\Postcategoryoption','term_id')->where('type','city')->with('category');
	}

	
	public function postcategory()
	{
		return $this->hasMany('App\PostCategory','term_id');
	}
	public function related()
	{
		return $this->hasMany('App\PostCategory','term_id');
	}



	public function Productcategory()
	{
		return $this->hasMany('App\PostCategory','term_id')->where('type','product_category');
	}
	
	public function user()
	{
		return $this->belongsTo('App\Models\User')->select('slug','name','id','email','avatar')->with('usermeta');
	}

	public function medias()
	{
		return $this->belongsToMany('App\Media','mediaposts','term_id','media_id');
	}

	public function preview()
	{
		
		return $this->hasOne('App\Meta','term_id')->where('type','preview')->select('id','term_id','type','content');		
	}

	public function gallery()
	{
		
		return $this->hasOne('App\Meta','term_id')->where('type','gallery')->select('id','term_id','type','content');		
	}

	public function seo()
	{
		return $this->hasOne('App\Meta','term_id')->where('type','seo')->select('id','term_id','type','content');
	}

	public function excerpt()
	{
		return $this->hasOne('App\Meta','term_id')->where('type','excerpt')->select('term_id','type','content');
	}

	public function content()
	{
		return $this->hasOne('App\Meta','term_id')->where('type','content')->select('term_id','type','content');
	}

	public function finished_at()
	{
		return $this->hasOne('App\Meta','term_id')->where('type','finished_at')->select('term_id','type','content');
	}

	public function open_sell_date()
	{
		return $this->hasOne('App\Meta','term_id')->where('type','open_sell_date')->select('term_id','type','content');
	}

	
	public function latitude()
	{
		return $this->hasOne('App\Models\Postcategoryoption','term_id')->where('type','latitude');
	}

	public function longitude()
	{
		return $this->hasOne('App\Models\Postcategoryoption','term_id')->where('type','longitude');
	}

	public function city()
	{
		return $this->hasOne('App\Models\Postcategoryoption','term_id')->where('type','city');
	}


	public function facilities()
	{
		return $this->hasMany('App\Models\Postcategoryoption','term_id')->where('type','facilities');
	}

	public function facilities_get()
	{
		return $this->hasMany('App\Models\Postcategoryoption','term_id')->where('type','facilities')->with('category');
	}

	public function options()
	{
		return $this->hasMany('App\Models\Postcategoryoption','term_id')->where('type','options');
	}

	public function option_data()
	{
		return $this->hasMany('App\Models\Postcategoryoption','term_id')->where('type','options')->with('category');
	}

	public function min_price()
	{
		return $this->belongsTo('App\Models\Price','id','term_id')->where('type','min_price');
	}

	public function max_price()
	{
		return $this->belongsTo('App\Models\Price','id','term_id')->where('type','max_price');
	}

	public function post_state()
	{
		return $this->hasOne('App\PostCategory','term_id')->where('type','state')->with('category');
	}

	public function featured_option()
	{
		return $this->hasMany('App\Models\Postcategoryoption','term_id')->whereHas('featured_category')->with('featured_category');
	}

	public function child()
	{
		return $this->hasOne('App\Models\Termrelation','term_id');
	}

	public function parent()
	{
		return $this->hasOne('App\Models\Termrelation','child_id','term_id');
	}

	public function connection()
	{
		return $this->hasMany('App\Models\Termrelation','child_id');
	}

	

	public function multiple_images(){
		return $this->hasMany('App\Models\Mediapost','term_id')->with('media');
	}


	
	public function youtube_url()
	{
		return $this->hasOne('App\Meta','term_id')->where('type','youtube_url')->select('term_id','type','content');
	}

	public function virtual_tour()
	{
		return $this->hasOne('App\Meta','term_id')->where('type','virtual_tour')->select('term_id','type','content');
	}

	public function reviews()
	{
		return $this->hasMany('App\Models\Review','term_id');
	}

	public function contact_type(){
		return $this->hasOne('App\Meta','term_id')->where('type','contact_type')->select('term_id','type','content');
	}

	public function favourite_to_users()
    {
        return $this->belongsToMany('App\Models\User')->withTimestamps();
	}
}
