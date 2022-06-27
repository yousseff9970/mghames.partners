<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\Review;
class TenantReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reviews=array(
        array(
            "id" => 3,
            "order_id" => 1,
            "user_id" => 1,
            "term_id" => 1,
            "rating" => 5,
            "comment" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s",
            "created_at" => "2021-12-01 08:03:30",
            "updated_at" => "2022-01-04 16:46:18"
        ),
        array(
            "id" => 4,
            "order_id" => 1,
            "user_id" => 1,
            "term_id" => 1,
            "rating" => 5,
            "comment" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s",
            "created_at" => "2021-12-01 08:03:30",
            "updated_at" => "2022-01-04 16:46:18"
        ),
        array(
            "id" => 5,
            "order_id" => 1,
            "user_id" => 1,
            "term_id" => 1,
            "rating" => 1,
            "comment" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s",
            "created_at" => "2021-12-01 08:03:30",
            "updated_at" => "2022-01-04 16:46:18"
        ),
        array(
            "id" => 6,
            "order_id" => 1,
            "user_id" => 1,
            "term_id" => 1,
            "rating" => 5,
            "comment" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s",
            "created_at" => "2021-12-01 08:03:30",
            "updated_at" => "2022-01-04 16:46:18"
        ),
        array(
            "id" => 8,
            "order_id" => 78,
            "user_id" => 1,
            "term_id" => 10,
            "rating" => 5,
            "comment" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s",
            "created_at" => "2022-01-04 16:42:18",
            "updated_at" => "2022-01-04 16:46:18"
        ),
        array(
            "id" => 9,
            "order_id" => 28,
            "user_id" => 1,
            "term_id" => 12,
            "rating" => 3,
            "comment" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s",
            "created_at" => "2022-01-04 17:27:54",
            "updated_at" => "2022-01-04 17:27:54"
        ),
        array(
            "id" => 10,
            "order_id" => 28,
            "user_id" => 1,
            "term_id" => 1,
            "rating" => 4,
            "comment" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s",
            "created_at" => "2022-01-04 17:29:11",
            "updated_at" => "2022-01-04 17:29:11"
        ),
        array(
            "id" => 11,
            "order_id" => 28,
            "user_id" => 1,
            "term_id" => 11,
            "rating" => 5,
            "comment" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s",
            "created_at" => "2022-01-04 17:29:25",
            "updated_at" => "2022-01-04 17:29:25"
        )
    );

        Review::insert($reviews);
    }
}
