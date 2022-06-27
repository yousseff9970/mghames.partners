<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\Productoption;
class TenantProductoptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productoptions= array(
            array(
                "id" => 1,
                "term_id" => 1,
                "category_id" => 9,
                "select_type" => 1,
                "is_required" => 1
            ),
            array(
                "id" => 2,
                "term_id" => 1,
                "category_id" => 4,
                "select_type" => 1,
                "is_required" => 1
            )
        );

        Productoption::insert($productoptions);
    }
}
