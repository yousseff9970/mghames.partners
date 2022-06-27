<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static  $seller_roles=['dashboard',
            'pos',
            'order',
            'calender',
            'products',
            'reviews',
            'users',
            'rider',
            'payment_gateway',
            'table',
            'website_settings',
            'admins'];

    public static function getpermissionGroups()
    {
        $permission_groups = DB::table('permissions')
        ->select('group_name as name')
        ->groupBy('group_name')
        ->get();
        return $permission_groups;
    }

    public static function getPermissionGroup()
    {
        return $permission_groups = DB::table('permissions')->select('group_name')->groupBy('group_name')->get();
    }
    
    public static function getpermissionsByGroupName($group_name)
    {
        $permissions = DB::table('permissions')
        ->select('name', 'id')
        ->where('group_name', $group_name)
        ->get();
        return $permissions;
    }

    public static function roleHasPermissions($role, $permissions)
    {
        $hasPermission = true;
        foreach ($permissions as $permission) {
            if (!$role->hasPermissionTo($permission->name)) {
                $hasPermission = false;
                return $hasPermission;
            }
        }
        return $hasPermission;
    }

    public function active_orders(){
        return $this->hasMany('App\Models\Order','user_id', 'id')->where('status', 1);
    }

    public function orders(){
        return $this->hasMany('App\Models\Order','user_id', 'id');
    }

    public function tenant()
    {
        return $this->hasMany('App\Models\Tenant');
    }
    public function supports()
    {
        return $this->hasMany('App\Models\Support');
    }

    public function fmctoken()
    {
       return $this->hasOne('App\Models\Devicetoken')->where('type','firebase');
    }

    public function rider_orders()
    {
        return $this->hasMany('App\Models\Ordershipping','user_id')->with('order');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id');
    }

    // public function complete_order()
    // {
    //     return $this->belongsTo('App\Models\Order','order_id')->where('status_id',1);
    // }

    // public function cancalled_order()
    // {
    //     return $this->belongsTo('App\Models\Order','order_id')->where('status_id',2);
    // }

    // public function pending_order()
    // {
    //     return $this->belongsTo('App\Models\Order','order_id')->where('status_id',3);
    // }

    public function user_orders()
    {
        return $this->hasMany('App\Models\Order')->with('orderstatus');
    }

    
}
