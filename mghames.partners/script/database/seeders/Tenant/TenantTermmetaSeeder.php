<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\Termmeta;
class TenantTermmetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metas=array(
        array(
            "id" => 1,
            "term_id" => 1,
            "key" => "excerpt",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor"
        ),
        array(
            "id" => 2,
            "term_id" => 2,
            "key" => "excerpt",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi"
        ),
        array(
            "id" => 3,
            "term_id" => 3,
            "key" => "excerpt",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor"
        ),
        array(
            "id" => 4,
            "term_id" => 4,
            "key" => "excerpt",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi"
        ),
        array(
            "id" => 5,
            "term_id" => 5,
            "key" => "excerpt",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem"
        ),
        array(
            "id" => 6,
            "term_id" => 6,
            "key" => "excerpt",
            "value" => "product short description"
        ),
        array(
            "id" => 7,
            "term_id" => 7,
            "key" => "excerpt",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem"
        ),
        array(
            "id" => 8,
            "term_id" => 8,
            "key" => "excerpt",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem"
        ),
        array(
            "id" => 9,
            "term_id" => 9,
            "key" => "excerpt",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem"
        ),
        array(
            "id" => 10,
            "term_id" => 10,
            "key" => "excerpt",
            "value" => "product short description"
        ),
        array(
            "id" => 11,
            "term_id" => 11,
            "key" => "excerpt",
            "value" => "product short description"
        ),
        array(
            "id" => 12,
            "term_id" => 12,
            "key" => "excerpt",
            "value" => "product short description"
        ),
        array(
            "id" => 13,
            "term_id" => 13,
            "key" => "excerpt",
            "value" => "product short description"
        ),
        array(
            "id" => 14,
            "term_id" => 14,
            "key" => "excerpt",
            "value" => "product short description"
        ),
        array(
            "id" => 15,
            "term_id" => 15,
            "key" => "excerpt",
            "value" => "product short description"
        ),
        array(
            "id" => 16,
            "term_id" => 16,
            "key" => "excerpt",
            "value" => "product short description"
        ),
        array(
            "id" => 17,
            "term_id" => 17,
            "key" => "excerpt",
            "value" => "product short description"
        ),
        array(
            "id" => 18,
            "term_id" => 18,
            "key" => "excerpt",
            "value" => "product short description"
        ),
        array(
            "id" => 19,
            "term_id" => 1,
            "key" => "preview",
            "value" => env('APP_URL')."/uploads/dummy/22/01/61dae4a4957dc0901221641735332.webp"
        ),
        array(
            "id" => 20,
            "term_id" => 1,
            "key" => "gallery",
            "value" => '["uploads/dummy/21/11/61a5d7f0f02803011211638258672.jpeg","uploads/dummy/21/11/61a5d6aaa53c03011211638258346.jpeg"]'
        ),
        array(
            "id" => 31,
            "term_id" => 20,
            "key" => "excerpt",
            "value" => "There are many variations of passages of Lorem Ipsumavailable."
        ),
        array(
            "id" => 32,
            "term_id" => 20,
            "key" => "preview",
            "value" => env('APP_URL')."/uploads/dummy/21/12/61ae4a937336a0612211638812307.jpg"
        ),
        array(
            "id" => 33,
            "term_id" => 20,
            "key" => "description",
            "value" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
        ),
        array(
            "id" => 34,
            "term_id" => 21,
            "key" => "excerpt",
            "value" => "There are many variations of passages of Lorem Ipsumavailable.There are many variations of passages of Lorem Ipsumavailable.There are many variations of passages of Lorem Ipsumavailable."
        ),
        array(
            "id" => 35,
            "term_id" => 21,
            "key" => "preview",
            "value" => env('APP_URL')."/uploads/dummy/21/12/61ae4a93836d50612211638812307.jpg"
        ),
        array(
            "id" => 36,
            "term_id" => 21,
            "key" => "description",
            "value" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
        ),
        array(
            "id" => 37,
            "term_id" => 22,
            "key" => "excerpt",
            "value" => "There are many variations of passages of Lorem Ipsum available."
        ),
        array(
            "id" => 38,
            "term_id" => 22,
            "key" => "preview",
            "value" => env('APP_URL')."/uploads/dummy/21/12/61ae4a939290c0612211638812307.jpg"
        ),
        array(
            "id" => 39,
            "term_id" => 22,
            "key" => "description",
            "value" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
        ),
        array(
            "id" => 40,
            "term_id" => 23,
            "key" => "excerpt",
            "value" => "There are many variations of passages of Lorem Ipsum available."
        ),
        array(
            "id" => 41,
            "term_id" => 23,
            "key" => "preview",
            "value" => env('APP_URL')."/uploads/dummy/21/12/61ae4a937336a0612211638812307.jpg"
        ),
        array(
            "id" => 42,
            "term_id" => 23,
            "key" => "description",
            "value" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
        ),
        array(
            "id" => 43,
            "term_id" => 24,
            "key" => "excerpt",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem"
        ),
        array(
            "id" => 44,
            "term_id" => 1,
            "key" => "description",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem"
        ),
        array(
            "id" => 45,
            "term_id" => 25,
            "key" => "meta",
            "value" => '{"page_excerpt":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer tooks","page_content":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."}'
        ),
        array(
            "id" => 46,
            "term_id" => 1,
            "key" => "seo",
            "value" => '{"preview":"/uploads/dummy/21/12/61af7a4466fcf0712211638890052.jpg","title":"Lorem ipsum indoor plants","tags":"food, fair","description":"testing"}'
        ),
        array(
            "id" => 47,
            "term_id" => 24,
            "key" => "preview",
            "value" => env('APP_URL')."/uploads/dummy/22/01/61dae5acd6f8f0901221641735596.webp"
        ),
        array(
            "id" => 48,
            "term_id" => 24,
            "key" => "description",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem"
        ),
        array(
            "id" => 49,
            "term_id" => 2,
            "key" => "description",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem"
        ),
        array(
            "id" => 50,
            "term_id" => 2,
            "key" => "preview",
            "value" => env('APP_URL')."/uploads/dummy/22/01/61dae5839945c0901221641735555.webp"
        ),
        array(
            "id" => 51,
            "term_id" => 3,
            "key" => "preview",
            "value" => env('APP_URL')."/uploads/dummy/22/01/61dae581602880901221641735553.webp"
        ),
        array(
            "id" => 52,
            "term_id" => 4,
            "key" => "preview",
            "value" => env('APP_URL')."/uploads/dummy/22/01/61dae57eeb1fe0901221641735550.webp"
        ),
        array(
            "id" => 53,
            "term_id" => 5,
            "key" => "preview",
            "value" => env('APP_URL')."/uploads/dummy/21/12/61b8bbf0aded91412211639496688.jpeg"
        ),
        array(
            "id" => 54,
            "term_id" => 6,
            "key" => "preview",
            "value" => env('APP_URL')."/uploads/dummy/22/01/61dae4a4957dc0901221641735332.webp"
        ),
        array(
            "id" => 55,
            "term_id" => 7,
            "key" => "preview",
            "value" => env('APP_URL')."/uploads/dummy/22/01/61dae57eeb1fe0901221641735550.webp"
        ),
        array(
            "id" => 56,
            "term_id" => 8,
            "key" => "preview",
            "value" => env('APP_URL')."/uploads/dummy/22/01/61dae5acd6f8f0901221641735596.webp"
        ),
        array(
            "id" => 57,
            "term_id" => 9,
            "key" => "preview",
            "value" => env('APP_URL')."/uploads/dummy/22/01/61dae5839945c0901221641735555.webp"
        ),
        array(
            "id" => 58,
            "term_id" => 10,
            "key" => "preview",
            "value" => env('APP_URL')."/uploads/dummy/22/01/61dae4a4957dc0901221641735332.webp"
        ),
        array(
            "id" => 59,
            "term_id" => 11,
            "key" => "preview",
            "value" => env('APP_URL')."/uploads/dummy/21/12/61b8bbf0aded91412211639496688.jpeg"
        ),
        array(
            "id" => 60,
            "term_id" => 3,
            "key" => "description",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem"
        ),
        array(
            "id" => 61,
            "term_id" => 4,
            "key" => "description",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem"
        ),
        array(
            "id" => 62,
            "term_id" => 5,
            "key" => "description",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem"
        ),
        array(
            "id" => 63,
            "term_id" => 7,
            "key" => "description",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem"
        ),
        array(
            "id" => 64,
            "term_id" => 8,
            "key" => "description",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem"
        ),
        array(
            "id" => 65,
            "term_id" => 9,
            "key" => "description",
            "value" => "Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem Quo vel minus ea dolor est quis ut perferendis illo voluptas temporibus aut nisi error ad tempor excepturi voluptatem"
        )
    );
        Termmeta::insert($metas);
    }
}
