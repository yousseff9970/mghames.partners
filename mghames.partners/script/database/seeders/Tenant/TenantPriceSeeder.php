<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\Price;
class TenantPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prices=array(
        array(
            "id" => 2,
            "term_id" => 2,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 24,
            "old_price" => null,
            "qty" => 3,
            "sku" => "#abc4",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 0
        ),
        array(
            "id" => 3,
            "term_id" => 3,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 43,
            "old_price" => null,
            "qty" => 33,
            "sku" => "#abc5",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 0
        ),
        array(
            "id" => 4,
            "term_id" => 4,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 23,
            "old_price" => null,
            "qty" => 13,
            "sku" => "#abc6",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 5,
            "term_id" => 5,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 11.76,
            "old_price" => 12,
            "qty" => 84,
            "sku" => "#abc7",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 6,
            "term_id" => 6,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 22.31,
            "old_price" => 23,
            "qty" => 33,
            "sku" => "#abc8",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 7,
            "term_id" => 7,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 40,
            "old_price" => 42,
            "qty" => 76,
            "sku" => "#abc9",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 8,
            "term_id" => 8,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 22,
            "old_price" => 25,
            "qty" => 33,
            "sku" => "#abc10",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 9,
            "term_id" => 9,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 12,
            "old_price" => null,
            "qty" => 33,
            "sku" => "#abc11",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 10,
            "term_id" => 10,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 32,
            "old_price" => null,
            "qty" => 143,
            "sku" => "#abc12",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 11,
            "term_id" => 11,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 26,
            "old_price" => null,
            "qty" => 33,
            "sku" => "#abc13",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 12,
            "term_id" => 12,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 28,
            "old_price" => null,
            "qty" => 33,
            "sku" => "#abc14",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 13,
            "term_id" => 13,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 30,
            "old_price" => null,
            "qty" => 43,
            "sku" => "#abc15",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 14,
            "term_id" => 14,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 20,
            "old_price" => null,
            "qty" => 33,
            "sku" => "#abc16",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 15,
            "term_id" => 15,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 27,
            "old_price" => null,
            "qty" => 143,
            "sku" => "#abc17",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 16,
            "term_id" => 16,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 23,
            "old_price" => null,
            "qty" => 33,
            "sku" => "#abc18",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 17,
            "term_id" => 17,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 28,
            "old_price" => null,
            "qty" => 34,
            "sku" => "#abc19",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 18,
            "term_id" => 18,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 23,
            "old_price" => null,
            "qty" => 12,
            "sku" => "#abc20",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 19,
            "term_id" => 1,
            "productoption_id" => 1,
            "category_id" => 10,
            "price" => 10,
            "old_price" => null,
            "qty" => 22,
            "sku" => "#1233",
            "weight" => 33,
            "stock_manage" => 0,
            "stock_status" => 0
        ),
        array(
            "id" => 20,
            "term_id" => 1,
            "productoption_id" => 1,
            "category_id" => 11,
            "price" => 300,
            "old_price" => null,
            "qty" => 33,
            "sku" => "#assww",
            "weight" => 22,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 21,
            "term_id" => 24,
            "productoption_id" => null,
            "category_id" => null,
            "price" => 120,
            "old_price" => null,
            "qty" => 834,
            "sku" => "#awsss",
            "weight" => 688,
            "stock_manage" => 1,
            "stock_status" => 0
        ),
        array(
            "id" => 22,
            "term_id" => 1,
            "productoption_id" => 2,
            "category_id" => 5,
            "price" => 10,
            "old_price" => null,
            "qty" => 11,
            "sku" => "#aa220",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 23,
            "term_id" => 1,
            "productoption_id" => 2,
            "category_id" => 6,
            "price" => 0,
            "old_price" => null,
            "qty" => 11,
            "sku" => "#aa22",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        ),
        array(
            "id" => 24,
            "term_id" => 1,
            "productoption_id" => 2,
            "category_id" => 7,
            "price" => 0,
            "old_price" => null,
            "qty" => 11,
            "sku" => "#aa22",
            "weight" => 0,
            "stock_manage" => 1,
            "stock_status" => 1
        )
    );
        Price::insert($prices);
    }
}
