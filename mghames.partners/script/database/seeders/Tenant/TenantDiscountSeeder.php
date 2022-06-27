<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\Discount;
class TenantDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $discounts=array(
           
                array(
                    "id" => 3,
                    "term_id" => 5,
                    "special_price" => 2,
                    "price_type" => 1,
                    "ending_date" => "2022-12-30"
                ),
                array(
                    "id" => 4,
                    "term_id" => 6,
                    "special_price" => 3,
                    "price_type" => 1,
                    "ending_date" => "2023-06-09"
                ),
                array(
                    "id" => 5,
                    "term_id" => 7,
                    "special_price" => 2,
                    "price_type" => 0,
                    "ending_date" => "2023-12-09"
                ),
                array(
                    "id" => 6,
                    "term_id" => 8,
                    "special_price" => 3,
                    "price_type" => 0,
                    "ending_date" => "2023-07-09"
                )
            
        );

        Discount::insert($discounts);
    }
}
