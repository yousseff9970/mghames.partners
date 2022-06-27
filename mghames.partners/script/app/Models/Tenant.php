<?php
namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'order_id','user_id','will_expire','data','status','auto_renew','uid','long'
    ];
   
    public static function getCustomColumns(): array
    {
        return [
            'id',
            'order_id',
            'user_id',
            'will_expire',
            'data',
            'status',
            'auto_renew',
            'uid',
            'lat',
            'long'
            
            
        ];
    }

  

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id');
    }

    public function orderwithplan()
    {
        return $this->belongsTo('App\Models\Order','order_id')->with('plan');
    }

    public function domain()
    {
        return $this->hasOne('App\Models\Domain');
    }

    public function domains()
    {
        return $this->hasMany('App\Models\Domain');
    }
    public function active_domains()
    {
        return $this->hasMany('App\Models\Domain')->where('status',1);
    }

    public function subdomain()
    {
        return $this->hasOne('App\Models\Domain')->where('type',2);
    }

    public function customdomain()
    {
        return $this->hasOne('App\Models\Domain')->where('type',3);
    }

    public function tenantorderlog()
    {
        return $this->hasMany('App\Models\Tenantorder');
    }

    public function tenantmeta()
    {
        return $this->hasOne('App\Models\Tenantmeta','tenant_id');
    }

}