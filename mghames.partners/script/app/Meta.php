<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $table="meta";
    public $timestamps = false;
    public function term()
    {
    	return $this->hasOne('App\Terms','id','term_id');
    }


}
