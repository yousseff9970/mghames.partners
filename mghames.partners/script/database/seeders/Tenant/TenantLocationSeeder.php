<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\Location;
class TenantLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations= array(
   
        array(
            "id" => 1,
            "name" => "Downtown Dallas",
            "slug" => "downtown-dallas",
            "avatar" => null,
            "lat" => 32.779,
            "long" => 96.8003,
            "range" => 11,
            "featured" => 0,
            "status" => 1,
            "created_at" => "2021-11-23 18:31:47",
            "updated_at" => "2021-11-23 18:31:47"
        ),
        array(
            "id" => 2,
            "name" => "Lake Highlands",
            "slug" => "lake-highlands",
            "avatar" => null,
            "lat" => 32.8874,
            "long" => 96.7173,
            "range" => 11,
            "featured" => 0,
            "status" => 1,
            "created_at" => "2021-11-23 18:32:18",
            "updated_at" => "2021-11-23 18:32:18"
        ),
        array(
            "id" => 3,
            "name" => "Cumilla",
            "slug" => "north-dallas",
            "avatar" => null,
            "lat" => 32.9621,
            "long" => 96.7864,
            "range" => 12,
            "featured" => 0,
            "status" => 1,
            "created_at" => "2021-11-23 18:32:48",
            "updated_at" => "2021-12-16 08:42:15"
        ),
        array(
            "id" => 4,
            "name" => "Sylet",
            "slug" => "oak-lawn",
            "avatar" => null,
            "lat" => 41.72,
            "long" => 87.748,
            "range" => 12,
            "featured" => 0,
            "status" => 1,
            "created_at" => "2021-11-23 18:33:20",
            "updated_at" => "2021-12-16 08:42:06"
        ),
        array(
            "id" => 5,
            "name" => "Dhaka",
            "slug" => "octavius-martin",
            "avatar" => null,
            "lat" => 25,
            "long" => 53,
            "range" => 50,
            "featured" => 0,
            "status" => 1,
            "created_at" => "2021-12-07 18:33:44",
            "updated_at" => "2021-12-16 08:41:39"
        ),
        array(
            "id" => 6,
            "name" => "Chittagong",
            "slug" => "iliana-carney",
            "avatar" => null,
            "lat" => 10,
            "long" => 22,
            "range" => 5,
            "featured" => 0,
            "status" => 1,
            "created_at" => "2021-12-07 18:35:21",
            "updated_at" => "2021-12-16 08:41:17"
        )
    );

        Location::insert($locations);
    }
}
