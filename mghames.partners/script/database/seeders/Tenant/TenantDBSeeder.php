<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Option;
use Illuminate\Support\Facades\Session;
use Sess;

class TenantDBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles  = User::$seller_roles;

        $super = User::create([
            'role_id' => 3,
            'name' => Session::get('store_data')['store_name'] ?? 'store owner',
            'email' => Session::get('store_data')['email'] ?? 'store@email.com',
            'password' => Hash::make(Session::get('store_data')['password'] ?? '12345678'),
            'permissions'=>json_encode($roles)
         ]      
        );

        $roleSuperAdmin = Role::create(['name' => 'superadmin']);
        //create permission
        $permissions = [
            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'dashboard',
                ]
            ],
           
            
            


        ];

        //assign permission

        foreach ($permissions as $key => $row) {
            foreach ($row['permissions'] as $per) {
                $permission = Permission::create(['name' => $per, 'group_name' => $row['group_name']]);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
                $super->assignRole($roleSuperAdmin);
            }
        }

        

        
        

        
    }
}













