<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\Term;
class TenantTermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $terms=array(
        array(
            "id" => 1,
            "full_id" => "0000001",
            "title" => "Lorem ipsum indoor plants",
            "slug" => "lorem-ipsum-indoor-plants",
            "type" => "product",
            "is_variation" => 1,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2022-01-04 17:29:11",
            "rating" => 4
        ),
        array(
            "id" => 2,
            "full_id" => "0000002",
            "title" => "Cillum dolore garden lorem ipsum tools",
            "slug" => "cillum-dolore-garden-lorem-ipsum-tools",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2021-11-30 07:41:41",
            "rating" => 5
        ),
        array(
            "id" => 3,
            "full_id" => "0000003",
            "title" => "Gardenia Jasminoides",
            "slug" => "gardenia-jasminoides",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2021-11-30 07:41:41",
            "rating" => 2.5
        ),
        array(
            "id" => 4,
            "full_id" => "0000004",
            "title" => "Ponytail Palm",
            "slug" => "ponytail-palm",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2021-11-30 07:41:41",
            "rating" => 4.3
        ),
        array(
            "id" => 5,
            "full_id" => "0000005",
            "title" => "Flamingo Plant",
            "slug" => "flamingo-plant",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2021-11-30 07:41:41",
            "rating" => 5
        ),
        array(
            "id" => 6,
            "full_id" => "0000006",
            "title" => "Heartleaf Philodendron",
            "slug" => "heartleaf-philodendron",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2021-11-30 07:41:41",
            "rating" => 5
        ),
        array(
            "id" => 7,
            "full_id" => "0000007",
            "title" => "Anthurium Turenza",
            "slug" => "anthurium-turenza",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2021-11-30 07:41:41",
            "rating" => 5
        ),
        array(
            "id" => 8,
            "full_id" => "0000008",
            "title" => "Dragon Tree Plant",
            "slug" => "dragon-tree-plant",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2021-11-30 07:41:41",
            "rating" => 4
        ),
        array(
            "id" => 9,
            "full_id" => "0000009",
            "title" => "Oilcloth Flower",
            "slug" => "oilcloth-flower",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2021-11-30 07:41:41",
            "rating" => 3
        ),
        array(
            "id" => 10,
            "full_id" => "0000010",
            "title" => "Dragon Tree Plant",
            "slug" => "dragon-tree-plant2",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2022-01-04 16:46:18",
            "rating" => 5
        ),
        array(
            "id" => 11,
            "full_id" => "0000011",
            "title" => "Flamingo Plant",
            "slug" => "flamingo-plant2",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2022-01-04 17:29:25",
            "rating" => 5
        ),
        array(
            "id" => 12,
            "full_id" => "0000012",
            "title" => "Calathea Makoyana",
            "slug" => "calathea-makoyana",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2022-01-04 17:27:54",
            "rating" => 3
        ),
        array(
            "id" => 13,
            "full_id" => "0000013",
            "title" => "Yucca Plant",
            "slug" => "yucca-plant",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2021-11-30 07:41:41",
            "rating" => 5
        ),
        array(
            "id" => 14,
            "full_id" => "0000014",
            "title" => "Oilcloth Flower",
            "slug" => "oilcloth-flower2",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2021-11-30 07:41:41",
            "rating" => 5
        ),
        array(
            "id" => 15,
            "full_id" => "0000015",
            "title" => "Ponytail Palm",
            "slug" => "ponytail-palm2",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2021-11-30 07:41:41",
            "rating" => 5
        ),
        array(
            "id" => 16,
            "full_id" => "0000016",
            "title" => "Anthurium Turenza",
            "slug" => "anthurium-turenza2",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2021-11-30 07:41:41",
            "rating" => null
        ),
        array(
            "id" => 17,
            "full_id" => "0000017",
            "title" => "Oilcloth Flower",
            "slug" => "oilcloth-flower2",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2021-11-30 07:41:41",
            "rating" => null
        ),
        array(
            "id" => 18,
            "full_id" => "0000018",
            "title" => "Oilcloth Flower",
            "slug" => "oilcloth-flower2",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-11-30 07:41:41",
            "updated_at" => "2021-11-30 07:41:41",
            "rating" => null
        ),
        array(
            "id" => 20,
            "full_id" => "0000020",
            "title" => "Restaurants Switched to Delivery Mode",
            "slug" => "restaurants-switched-to-delivery-mode",
            "type" => "blog",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-12-06 17:39:06",
            "updated_at" => "2021-12-06 17:39:06",
            "rating" => null
        ),
        array(
            "id" => 21,
            "full_id" => "0000021",
            "title" => "Bottled Water Home Delivery Companies",
            "slug" => "bottled-water-home-delivery-companies",
            "type" => "blog",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-12-06 17:39:28",
            "updated_at" => "2021-12-06 17:39:28",
            "rating" => null
        ),
        array(
            "id" => 22,
            "full_id" => "0000022",
            "title" => "Creative Packaging as a Successful Marketing",
            "slug" => "creative-packaging-as-a-successful-marketing",
            "type" => "blog",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-12-06 17:40:07",
            "updated_at" => "2021-12-06 17:40:07",
            "rating" => null
        ),
        array(
            "id" => 23,
            "full_id" => "0000023",
            "title" => "Bottled Water Home Delivery Companies",
            "slug" => "bottled-water-home-delivery-companies",
            "type" => "blog",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-12-06 17:40:33",
            "updated_at" => "2021-12-06 17:40:33",
            "rating" => null
        ),
        array(
            "id" => 24,
            "full_id" => "0000024",
            "title" => "Simone Torres",
            "slug" => "simone-torres",
            "type" => "product",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-12-07 18:07:25",
            "updated_at" => "2021-12-27 15:20:21",
            "rating" => 5
        ),
        array(
            "id" => 25,
            "full_id" => "0000025",
            "title" => "Terms and conditions",
            "slug" => "terms-and-conditions",
            "type" => "page",
            "is_variation" => 0,
            "status" => 1,
            "featured" => null,
            "created_at" => "2021-12-25 13:48:51",
            "updated_at" => "2022-01-09 14:14:18",
            "rating" => null
        )
    );
        
        Term::insert($terms);
    }
}
