<?php

namespace Database\Seeders;

use Database\Seeders\Tenant\TenantDBSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call([
            UsertableSeeder::class,
            PaymentGatewaySeeder::class,       
            OptionSeeder::class,    
            MenuTableSeeder::class
             
       ]);
    }
}
