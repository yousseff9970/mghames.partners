<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
   use HasFactory;
   protected $table="plans";

   //if you want to add more plan data just add new value in array
   public $plandata=[
      'sub_domain'=>array(
         'type' => 'option',
         'value'=>['Yes'=>'on','No'=>'off']
      ),
      'custom_domain'=>array(
         'type' => 'option',
         'value'=>['Yes'=>'on','No'=>'off']
      ),
     
      'barcode'=>array(
         'type' => 'option',
         'value'=>['Yes'=>'on','No'=>'off']
      ),
      'qr_code'=>array(
         'type' => 'option',
         'value'=>['Yes'=>'on','No'=>'off']
      ),
      
      'customer_modules'=>array(
          'type' => 'option',
          'value'=>['Yes'=>'on','No'=>'off']
      ),
      'pos'=>array(
          'type' => 'option',
          'value'=>['Yes'=>'on','No'=>'off']
      ),
      'push_notification'=>array(
          'type' => 'option',
          'value'=>['Yes'=>'on','No'=>'off']
      ),
      'image_optimization'=>array(
          'type' => 'option',
          'value'=>['Yes'=>'on','No'=>'off']
      ),
      'custom_css_js'=>array(
          'type' => 'option',
          'value'=>['Yes'=>'on','No'=>'off']
      ),
      'pwa'=>array(
          'type' => 'option',
          'value'=>['Yes'=>'on','No'=>'off']
      ),
       'storage_limit'=>array(
         'type' => 'number',
         'value'=> 0
      ),
      'post_limit'=>array(
         'type' => 'number',
         'value'=> 0
      ),
      'staff_limit'=>array(
         'type' => 'number',
         'value'=> 0
      ),
      
    ];

    public function active_users()
    {
    	return $this->hasMany('App\Models\Order')->where('status',1);
    }
    public function orders()
    {
    	return $this->hasMany('App\Models\Order');
    }

   
}
