<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class UsertableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
       
        $super = User::create([
    		'role_id' => 1,
    		'name' => 'Admin',
    		'email' => 'admin@admin.com',
    		'password' => Hash::make('rootadmin'),
		]);

        User::create([
    		'role_id' => 2,
    		'name' => 'Merchant',
    		'email' => 'merchant@gmail.com',
    		'password' => Hash::make('rootmerchant')
		]);	

		
		
    	$roleSuperAdmin = Role::create(['name' => 'superadmin']);
        //create permission
    	$permissions = [
    		[
    			'group_name' => 'dashboard',
    			'permissions' => [
    				'dashboard.index',
    			]
    		],
    		[
    			'group_name' => 'cron',
    			'permissions' => [
    				'cron.settings',
    			]
    		],
    		[
    			'group_name' => 'admin',
    			'permissions' => [
    				'admin.create',
    				'admin.edit',
    				'admin.update',
    				'admin.delete',
    				'admin.list',
    			]
    		],
    		[
    			'group_name' => 'role',
    			'permissions' => [
    				'role.create',
    				'role.edit',
    				'role.update',
    				'role.delete',
    				'role.list',

    			]
    		],
            [
                'group_name' => 'page',
                'permissions' => [
                    'page.create',
                    'page.edit',
                    'page.delete',
                    'page.index',

                ]
			],
			[
                'group_name' => 'transaction',
                'permissions' => [
                    'transaction',
                    'fund'
                ]
			],
			[
                'group_name' => 'themes',
                'permissions' => [
                    'store.theme',
                    'site.theme'
                ]
			],
			[
                'group_name' => 'support',
                'permissions' => [
                    'support.index',
                    'support.delete',
                    'support.create',
                ]
			],
			[
                'group_name' => 'title',
                'permissions' => [
                    'title',
                ]
			],
			
            [
				'group_name' => 'Blog',
				'permissions' => [
					'blog.create',
					'blog.edit',
					'blog.delete',
					'blog.index',
				]
			],
			[
				'group_name' => 'getway',
				'permissions' => [
					'getway.edit',
					'getway.index',
				]
			],

			[
				'group_name' => 'plan',
				'permissions' => [
					'plan.create',
					'plan.edit',
					'plan.index',
					'plan.delete',
					'plan.show',
				]
			],

			[
				'group_name' => 'report',
				'permissions' => [
					'report',
					
				]
			],

			[
				'group_name' => 'option',
				'permissions' => [
					'option',
				]
			],

			[
				'group_name' => 'support',
				'permissions' => [
					'support',
				]
			],
			
			[
				'group_name' => 'Settings',
				'permissions' => [
					'site.settings',
					'system.settings',
					'seo.settings',
					'menu',
				]
			],

			
			[
				'group_name' => 'users',
				'permissions' => [
					'user.create',
					'user.index',
					'user.delete',
					'user.edit',
					'user.verified',
					'user.show',
					'user.banned',
					'user.unverified',
					'user.mail',
					'user.invoice',
				]
			],
			
			[
				'group_name' => 'language',
				'permissions' => [
					'language.index',
					'language.edit',
					'language.create',
					'language.delete',
				]
			],
			[
				'group_name' => 'domain',
				'permissions' => [
					'domain.list',
					'domain.edit',
					'domain.create',
					'domain.show',
					'domain.delete',
					'dns.settings',
				]
			],
			[
				'group_name' => 'order',
				'permissions' => [
					'order.index',
					'order.edit',
					'order.create',
					'order.show',
					'order.delete',
				]
			],
			[
                'group_name'  => 'merchant',
                'permissions' => [
                    'merchant.index',
                    'merchant.edit',
                    'merchant.create',
                    'merchant.delete',
                    'merchant.mail',
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
