<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                "id" => 1,
                "name" => "Header",
                "position" => "header",
                "data" => "[{\"text\":\"Home\",\"href\":\"/\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Pricing\",\"icon\":\"\",\"href\":\"/pricing\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Demos\",\"icon\":\"empty\",\"href\":\"/demos\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Blogs\",\"icon\":\"empty\",\"href\":\"/blogs\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Contact\",\"icon\":\"empty\",\"href\":\"/contact\",\"target\":\"_self\",\"title\":\"\"}]",
                "lang" => "en",
                "status" => 1,
                "created_at" => "2021-12-15 18:19:19",
                "updated_at" => "2021-12-23 13:14:47"
            ],
            [
                "id" => 2,
                "name" => "Footer",
                "position" => "footer",
                "data" => "[{\"text\":\"Privacy\",\"icon\":\"\",\"href\":\"#\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Policy\",\"icon\":\"empty\",\"href\":\"#\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Terms of Service\",\"icon\":\"empty\",\"href\":\"#\",\"target\":\"_self\",\"title\":\"\"}]",
                "lang" => "en",
                "status" => 1,
                "created_at" => "2021-12-23 14:05:50",
                "updated_at" => "2021-12-23 14:06:36"
            ],
            [
                "id" => 3,
                "name" => "About Company",
                "position" => "footer_left_menu",
                "data" => "[{\"text\":\"About\",\"icon\":\"\",\"href\":\"#\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Team Member\",\"icon\":\"empty\",\"href\":\"#\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Our Portfolio\",\"icon\":\"empty\",\"href\":\"#\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"News\",\"icon\":\"empty\",\"href\":\"#\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Company History\",\"icon\":\"empty\",\"href\":\"#\",\"target\":\"_self\",\"title\":\"\"}]",
                "lang" => "en",
                "status" => 1,
                "created_at" => "2021-12-23 14:15:43",
                "updated_at" => "2021-12-23 14:18:02"
            ],
            [
                "id" => 4,
                "name" => "Our Services",
                "position" => "footer_right_menu",
                "data" => "[{\"text\":\"Restaurants Solution\",\"icon\":\"\",\"href\":\"#\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Lifecycle Management\",\"icon\":\"empty\",\"href\":\"#\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Sass development\",\"icon\":\"empty\",\"href\":\"#\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"App development\",\"icon\":\"empty\",\"href\":\"#\",\"target\":\"_self\",\"title\":\"\"},{\"text\":\"Digital agency\",\"icon\":\"empty\",\"href\":\"#\",\"target\":\"_self\",\"title\":\"\"}]",
                "lang" => "en",
                "status" => 1,
                "created_at" => "2021-12-23 14:15:58",
                "updated_at" => "2021-12-23 14:22:13"
            ]
        ];

        Menu::insert($menus);
    }
}
