<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\Shippingcategory;
class TenantShippingcategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            array(
                "category_id" => 30,
                "location_id" => 5
            ),
            array(
                "category_id" => 30,
                "location_id" => 4
            ),
            array(
                "category_id" => 30,
                "location_id" => 3
            ),
            array(
                "category_id" => 51,
                "location_id" => 6
            ),
            array(
                "category_id" => 51,
                "location_id" => 5
            )
        );
        Shippingcategory::insert($data);
    }
}
