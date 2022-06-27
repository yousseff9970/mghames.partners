<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\Termcategory;
class TenantTermcategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data= array(
            array(
                "term_id" => 2,
                "category_id" => 22
            ),
            array(
                "term_id" => 2,
                "category_id" => 28
            ),
            array(
                "term_id" => 1,
                "category_id" => 21
            ),
            array(
                "term_id" => 1,
                "category_id" => 29
            ),
            array(
                "term_id" => 24,
                "category_id" => 31
            ),
            array(
                "term_id" => 24,
                "category_id" => 22
            ),
            array(
                "term_id" => 24,
                "category_id" => 21
            ),
            array(
                "term_id" => 24,
                "category_id" => 28
            ),
            array(
                "term_id" => 24,
                "category_id" => 17
            ),
            array(
                "term_id" => 1,
                "category_id" => 18
            ),
            array(
                "term_id" => 1,
                "category_id" => 17
            ),
            array(
                "term_id" => 1,
                "category_id" => 20
            ),
            array(
                "term_id" => 1,
                "category_id" => 50
            ),
            array(
                "term_id" => 2,
                "category_id" => 31
            ),
            array(
                "term_id" => 1,
                "category_id" => 22
            ),
            array(
                "term_id" => 3,
                "category_id" => 29
            ),
            array(
                "term_id" => 3,
                "category_id" => 50
            ),
            array(
                "term_id" => 4,
                "category_id" => 29
            ),
            array(
                "term_id" => 4,
                "category_id" => 50
            ),
            array(
                "term_id" => 5,
                "category_id" => 29
            ),
            array(
                "term_id" => 5,
                "category_id" => 50
            ),
            array(
                "term_id" => 7,
                "category_id" => 29
            ),
            array(
                "term_id" => 7,
                "category_id" => 50
            ),
            array(
                "term_id" => 8,
                "category_id" => 29
            ),
            array(
                "term_id" => 8,
                "category_id" => 50
            ),
            array(
                "term_id" => 9,
                "category_id" => 29
            ),
            array(
                "term_id" => 9,
                "category_id" => 50
            ),
            array(
                "term_id" => 8,
                "category_id" => 23
            ),
            array(
                "term_id" => 8,
                "category_id" => 15
            ),
            array(
                "term_id" => 4,
                "category_id" => 15
            )
        );
        
        Termcategory::insert($data);
    }
}
