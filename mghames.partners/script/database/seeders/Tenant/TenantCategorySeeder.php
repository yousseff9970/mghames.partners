<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Categorymeta;
class TenantCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $categories=array (
        0 => 
        array (
          'id' => 1,
          'name' => 'Complete',
          'slug' => '#028a74',
          'type' => 'status',
          'category_id' => NULL,
          'featured' => 1,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-11-18 14:29:40',
          'updated_at' => '2021-11-18 14:35:42',
        ),
        1 => 
        array (
          'id' => 2,
          'name' => 'Cancel',
          'slug' => '#dc3545',
          'type' => 'status',
          'category_id' => NULL,
          'featured' => 2,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-11-18 14:30:00',
          'updated_at' => '2021-11-18 14:36:26',
        ),
        2 => 
        array (
          'id' => 3,
          'name' => 'Pending',
          'slug' => '#ffc107',
          'type' => 'status',
          'category_id' => NULL,
          'featured' => 3,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-11-18 14:30:37',
          'updated_at' => '2021-11-18 14:33:34',
        ),
        3 => 
        array (
          'id' => 4,
          'name' => 'Size',
          'slug' => 'radio',
          'type' => 'parent_attribute',
          'category_id' => NULL,
          'featured' => 1,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-11-18 14:37:38',
          'updated_at' => '2021-11-18 14:37:38',
        ),
        4 => 
        array (
          'id' => 5,
          'name' => 'Red',
          'slug' => 'Red',
          'type' => 'child_attribute',
          'category_id' => 4,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => NULL,
          'updated_at' => NULL,
        ),
        5 => 
        array (
          'id' => 6,
          'name' => 'Green',
          'slug' => 'Green',
          'type' => 'child_attribute',
          'category_id' => 4,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => NULL,
          'updated_at' => NULL,
        ),
        6 => 
        array (
          'id' => 7,
          'name' => 'Blue',
          'slug' => 'Blue',
          'type' => 'child_attribute',
          'category_id' => 4,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => NULL,
          'updated_at' => NULL,
        ),
        7 => 
        array (
          'id' => 8,
          'name' => 'Black',
          'slug' => 'Black',
          'type' => 'child_attribute',
          'category_id' => 4,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => NULL,
          'updated_at' => NULL,
        ),
        8 => 
        array (
          'id' => 9,
          'name' => 'Color',
          'slug' => 'checkbox',
          'type' => 'parent_attribute',
          'category_id' => NULL,
          'featured' => 1,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-11-18 14:38:12',
          'updated_at' => '2021-12-08 17:36:34',
        ),
        9 => 
        array (
          'id' => 10,
          'name' => 'M',
          'slug' => 'M',
          'type' => 'child_attribute',
          'category_id' => 9,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => NULL,
          'updated_at' => NULL,
        ),
        10 => 
        array (
          'id' => 11,
          'name' => 'L',
          'slug' => 'L',
          'type' => 'child_attribute',
          'category_id' => 9,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => NULL,
          'updated_at' => NULL,
        ),
        11 => 
        array (
          'id' => 12,
          'name' => 'S',
          'slug' => 'S',
          'type' => 'child_attribute',
          'category_id' => 9,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => NULL,
          'updated_at' => NULL,
        ),
        12 => 
        array (
          'id' => 13,
          'name' => 'XL',
          'slug' => 'XL',
          'type' => 'child_attribute',
          'category_id' => 9,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => NULL,
          'updated_at' => NULL,
        ),
        13 => 
        array (
          'id' => 14,
          'name' => 'XXL',
          'slug' => 'XXL',
          'type' => 'child_attribute',
          'category_id' => 9,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => NULL,
          'updated_at' => NULL,
        ),
        14 => 
        array (
          'id' => 15,
          'name' => 'Salad',
          'slug' => 'salad',
          'type' => 'category',
          'category_id' => NULL,
          'featured' => 0,
          'menu_status' => 1,
          'status' => 1,
          'created_at' => '2021-11-18 14:45:44',
          'updated_at' => '2021-12-04 16:56:31',
        ),
        15 => 
        array (
          'id' => 16,
          'name' => 'Organic',
          'slug' => 'organic',
          'type' => 'tag',
          'category_id' => NULL,
          'featured' => 1,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-11-23 17:30:31',
          'updated_at' => '2021-11-23 17:30:31',
        ),
        16 => 
        array (
          'id' => 17,
          'name' => 'Vegan',
          'slug' => 'vegan',
          'type' => 'tag',
          'category_id' => NULL,
          'featured' => 1,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-11-23 17:30:44',
          'updated_at' => '2021-11-23 17:31:34',
        ),
        17 => 
        array (
          'id' => 18,
          'name' => 'Fresh food',
          'slug' => 'fresh-food',
          'type' => 'tag',
          'category_id' => NULL,
          'featured' => 1,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-11-23 17:31:01',
          'updated_at' => '2021-11-23 17:32:08',
        ),
        18 => 
        array (
          'id' => 19,
          'name' => 'Healthy',
          'slug' => 'healthy',
          'type' => 'tag',
          'category_id' => NULL,
          'featured' => 1,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-11-23 17:31:19',
          'updated_at' => '2021-11-23 17:31:19',
        ),
        19 => 
        array (
          'id' => 20,
          'name' => 'Sandwiches',
          'slug' => 'sandwiches',
          'type' => 'category',
          'category_id' => NULL,
          'featured' => 1,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-11-23 17:34:20',
          'updated_at' => '2021-11-23 17:34:20',
        ),
        20 => 
        array (
          'id' => 21,
          'name' => 'Burgers',
          'slug' => 'burgers',
          'type' => 'category',
          'category_id' => NULL,
          'featured' => 1,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-11-23 17:34:42',
          'updated_at' => '2021-11-23 17:34:42',
        ),
        21 => 
        array (
          'id' => 22,
          'name' => 'Fried chicken',
          'slug' => 'fried-chicken',
          'type' => 'category',
          'category_id' => NULL,
          'featured' => 1,
          'menu_status' => 1,
          'status' => 1,
          'created_at' => '2021-11-23 17:34:59',
          'updated_at' => '2021-12-04 17:01:01',
        ),
        22 => 
        array (
          'id' => 23,
          'name' => 'french fries',
          'slug' => 'french-fries',
          'type' => 'category',
          'category_id' => NULL,
          'featured' => 1,
          'menu_status' => 1,
          'status' => 1,
          'created_at' => '2021-11-23 17:35:19',
          'updated_at' => '2021-12-04 17:26:06',
        ),
        23 => 
        array (
          'id' => 25,
          'name' => 'Samsung',
          'slug' => 'samsung',
          'type' => 'brand',
          'category_id' => NULL,
          'featured' => 1,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-11-23 18:24:43',
          'updated_at' => '2021-11-23 18:24:43',
        ),
        24 => 
        array (
          'id' => 26,
          'name' => 'Huawei',
          'slug' => 'huawei',
          'type' => 'brand',
          'category_id' => NULL,
          'featured' => 1,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-11-23 18:24:50',
          'updated_at' => '2021-11-23 18:24:50',
        ),
        25 => 
        array (
          'id' => 27,
          'name' => 'Sony',
          'slug' => 'sony',
          'type' => 'brand',
          'category_id' => NULL,
          'featured' => 1,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-11-23 18:24:54',
          'updated_at' => '2021-11-23 18:24:54',
        ),
        26 => 
        array (
          'id' => 28,
          'name' => 'Apple',
          'slug' => 'apple',
          'type' => 'brand',
          'category_id' => NULL,
          'featured' => 1,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-11-23 18:24:57',
          'updated_at' => '2021-11-23 18:24:57',
        ),
        27 => 
        array (
          'id' => 29,
          'name' => 'Envato',
          'slug' => 'envato',
          'type' => 'brand',
          'category_id' => NULL,
          'featured' => 1,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-11-23 18:25:18',
          'updated_at' => '2021-11-23 18:25:18',
        ),
        28 => 
        array (
          'id' => 30,
          'name' => 'Free delivery',
          'slug' => '0',
          'type' => 'shipping',
          'category_id' => NULL,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-11-23 18:34:05',
          'updated_at' => '2021-11-23 18:34:30',
        ),
        29 => 
        array (
          'id' => 31,
          'name' => 'New',
          'slug' => 'new',
          'type' => 'product_feature',
          'category_id' => NULL,
          'featured' => 0,
          'menu_status' => 1,
          'status' => 1,
          'created_at' => '2021-12-05 17:29:27',
          'updated_at' => '2021-12-13 19:16:15',
        ),
        30 => 
        array (
          'id' => 37,
          'name' => 'Order Healthy And Fresh Food Any Time',
          'slug' => '{"link":"/products","button_text":"View All Foods"}',
          'type' => 'slider',
          'category_id' => NULL,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-12-06 16:06:13',
          'updated_at' => '2021-12-06 16:06:13',
        ),
        31 => 
        array (
          'id' => 38,
          'name' => 'Order Healthy And Fresh <span>Food</span> Any Time',
          'slug' => '{"link":"#","button_text":"Shop Now"}',
          'type' => 'slider',
          'category_id' => NULL,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-12-06 16:07:29',
          'updated_at' => '2021-12-06 16:28:04',
        ),
        32 => 
        array (
          'id' => 39,
          'name' => 'Order Healthy And Fresh Food Any Time',
          'slug' => '{"link":"http://porichoy.test/","button_text":"#"}',
          'type' => 'slider',
          'category_id' => NULL,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-12-06 16:08:01',
          'updated_at' => '2021-12-06 16:08:01',
        ),
        33 => 
        array (
          'id' => 40,
          'name' => 'The Best Meat In Your City',
          'slug' => '{"link":"#","button_text":"Order Now"}',
          'type' => 'short_banner',
          'category_id' => NULL,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-12-06 16:33:15',
          'updated_at' => '2021-12-06 16:33:15',
        ),
        34 => 
        array (
          'id' => 41,
          'name' => 'Testy hot spicy  <br> double layer burger',
          'slug' => '{"link":"http://porichoy.test/","button_text":"Order Now"}',
          'type' => 'short_banner',
          'category_id' => NULL,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-12-06 16:34:13',
          'updated_at' => '2021-12-06 16:34:13',
        ),
        35 => 
        array (
          'id' => 42,
          'name' => 'Make Your First Order And Get <span>50% Off</span>',
          'slug' => '{"link":"https://shop1.shopifire.test/","button_text":"Order Now"}',
          'type' => 'large_banner',
          'category_id' => NULL,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-12-06 17:07:11',
          'updated_at' => '2021-12-06 17:08:10',
        ),
        36 => 
        array (
          'id' => 43,
          'name' => 'Special Juicy Burger House with discounts',
          'slug' => '{"days":"Monday - Saturdays","time":"09:00AM - 18:00PM","link":"https://shop1.shopifire.test/"}',
          'type' => 'special_menu',
          'category_id' => NULL,
          'featured' => 1,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-12-07 15:16:58',
          'updated_at' => '2021-12-07 15:28:35',
        ),
        37 => 
        array (
          'id' => 44,
          'name' => 'Restaurant Monaco',
          'slug' => '{"days":"Saturday - Friday","time":"10:00AM - 18:00PM","link":"#"}',
          'type' => 'special_menu',
          'category_id' => NULL,
          'featured' => 5,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-12-07 15:17:53',
          'updated_at' => '2021-12-07 15:30:44',
        ),
        38 => 
        array (
          'id' => 45,
          'name' => 'Ribs and Beer',
          'slug' => '{"days":"Wednesday - Sunday","time":"10:00AM - 05:00PM","link":"#"}',
          'type' => 'special_menu',
          'category_id' => NULL,
          'featured' => 3,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-12-07 15:20:00',
          'updated_at' => '2021-12-07 15:29:27',
        ),
        39 => 
        array (
          'id' => 46,
          'name' => 'Sushiteria',
          'slug' => '{"days":"Monday - Tuesday","time":"11:00AM - 12:00PM","link":"#"}',
          'type' => 'special_menu',
          'category_id' => NULL,
          'featured' => 4,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-12-07 15:20:46',
          'updated_at' => '2021-12-07 15:30:34',
        ),
        40 => 
        array (
          'id' => 47,
          'name' => 'Sushiteria',
          'slug' => '{"days":"Monday - Tuesday","time":"11:00AM - 12:00PM","link":"#"}',
          'type' => 'special_menu',
          'category_id' => NULL,
          'featured' => 2,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-12-07 15:21:19',
          'updated_at' => '2021-12-07 15:30:23',
        ),
        41 => 
        array (
          'id' => 50,
          'name' => 'Best selling',
          'slug' => 'best-selling',
          'type' => 'product_feature',
          'category_id' => NULL,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-12-13 19:16:27',
          'updated_at' => '2021-12-13 19:16:27',
        ),
        42 => 
        array (
          'id' => 51,
          'name' => 'SA Paribahan',
          'slug' => '100',
          'type' => 'shipping',
          'category_id' => NULL,
          'featured' => 0,
          'menu_status' => 0,
          'status' => 1,
          'created_at' => '2021-12-16 08:40:57',
          'updated_at' => '2021-12-16 08:40:57',
        ),
      );

    Category::insert($categories);

    $metas= array(
        array(
            "id" => 1,
            "category_id" => 23,
            "type" => "icon",
            "content" => env('APP_URL')."/uploads/dummy/21/12/61aba4d0328730412211638638800.png"
        ),
        array(
            "id" => 2,
            "category_id" => 31,
            "type" => "description",
            "content" => "Ut similique cupidit"
        ),
        array(
            "id" => 13,
            "category_id" => 37,
            "type" => "description",
            "content" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste laborum deleniti nam in quos qui nemo ipsum numquam."
        ),
        array(
            "id" => 14,
            "category_id" => 37,
            "type" => "preview",
            "content" => env('APP_URL')."/uploads/dummy/21/12/61ae34edec7010612211638806765.jpeg"
        ),
        array(
            "id" => 15,
            "category_id" => 38,
            "type" => "description",
            "content" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste laborum deleniti nam in quos qui nemo ipsum numquam."
        ),
        array(
            "id" => 16,
            "category_id" => 38,
            "type" => "preview",
            "content" => env('APP_URL')."/uploads/dummy/21/12/61ae34edb6a750612211638806765.jpg"
        ),
        array(
            "id" => 17,
            "category_id" => 39,
            "type" => "description",
            "content" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste laborum deleniti nam in quos qui nemo ipsum numquam."
        ),
        array(
            "id" => 18,
            "category_id" => 39,
            "type" => "preview",
            "content" => env('APP_URL')."/uploads/dummy/21/12/61ae34edd45450612211638806765.jpg"
        ),
        array(
            "id" => 19,
            "category_id" => 40,
            "type" => "preview",
            "content" => env('APP_URL')."/uploads/dummy/21/12/61ae3b2b9b8b80612211638808363.jpg"
        ),
        array(
            "id" => 20,
            "category_id" => 41,
            "type" => "preview",
            "content" => env('APP_URL')."/uploads/dummy/21/12/61ae3b1ad946c0612211638808346.jpg"
        ),
        array(
            "id" => 21,
            "category_id" => 42,
            "type" => "description",
            "content" => "If you order food delivery from us for the first time then we have a gift - 50% discount for you on the first order. You just need to register and order your favorite food."
        ),
        array(
            "id" => 22,
            "category_id" => 42,
            "type" => "preview",
            "content" => env('APP_URL')."/uploads/dummy/21/12/61ae42f85f3b90612211638810360.jpg"
        ),
        array(
            "id" => 23,
            "category_id" => 43,
            "type" => "preview",
            "content" => env('APP_URL')."/uploads/dummy/22/01/61dae4a4957dc0901221641735332.webp"
        ),
        array(
            "id" => 24,
            "category_id" => 44,
            "type" => "preview",
            "content" => env('APP_URL')."/uploads/dummy/21/12/61ae4a937336a0612211638812307.jpg"
        ),
        array(
            "id" => 25,
            "category_id" => 45,
            "type" => "preview",
            "content" => env('APP_URL')."/uploads/dummy/21/12/61af7a4466fcf0712211638890052.jpg"
        ),
        array(
            "id" => 26,
            "category_id" => 46,
            "type" => "preview",
            "content" => env('APP_URL')."/uploads/dummy/21/12/61af7a4466fcf0712211638890052.jpg"
        ),
        array(
            "id" => 27,
            "category_id" => 47,
            "type" => "preview",
            "content" => env('APP_URL')."/uploads/dummy/21/12/61ae4a93836d50612211638812307.jpg"
        ),
        array(
            "id" => 30,
            "category_id" => 23,
            "type" => "description",
            "content" => "testing"
        ),
        array(
            "id" => 31,
            "category_id" => 23,
            "type" => "preview",
            "content" => env('APP_URL')."/uploads/dummy/21/12/61af7a44566300712211638890052.jpg"
        )
    );
    Categorymeta::insert($metas);


  }
}
