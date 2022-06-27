<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TenantDataBaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call([
            //\Database\Seeders\Tenant\TenantDBSeeder::class,
            //\Database\Seeders\Tenant\TenantOptionSeeder::class,
            \Database\Seeders\Tenant\TenantCategorySeeder::class,
            \Database\Seeders\Tenant\TenantLocationSeeder::class,
            \Database\Seeders\Tenant\TenantGetwaySeeder::class,
            \Database\Seeders\Tenant\TenantMenuSeeder::class,
            \Database\Seeders\Tenant\TenantShippingcategoriesSeeder::class,
            \Database\Seeders\Tenant\TenantTermSeeder::class,
            \Database\Seeders\Tenant\TenantTermmetaSeeder::class,
            \Database\Seeders\Tenant\TenantProductoptionSeeder::class,
            \Database\Seeders\Tenant\TenantPriceSeeder::class,
            \Database\Seeders\Tenant\TenantTermcategoriesSeeder::class,
            \Database\Seeders\Tenant\TenantDiscountSeeder::class,
            
            
            
       ]);
    }
}
