<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Plan;
use App\Models\Term;
use App\Models\Termmeta;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $options = array(
        array('id' => '1','key' => 'gateway_section','value' => '{"first_title":"Protect yourself and your customers with advanced fraud detection","second_title":"Detailed reporting for accounting, reconciliation, and audits","first_des":"Lenden’s combination of automated and manual fraud systems protect you from fraudulent transactions and associated chargeback claims.","second_des":"Understand your customers’ purchase patterns and do easy reconciliations with a robust data Dashboard and easy exports.","image":"uploads\\/gateway_section\\/21\\/04\\/1698171749952367.png"}'),
        array('id' => '2','key' => 'auto_enroll_after_payment','value' => 'on'),
        array('id' => '3','key' => 'tawk_to_property_id','value' => '6076c018f7ce1827093a4822'),

        array('id' => '4','key' => 'cron_option','value' => '{"days":10,"alert_message":"Hi, your plan will expire soon","expire_message":"Your plan is expired!","trial_expired_message":"Your free trial is expired!"}'),

        array('id' => '5','key' => 'theme_settings','value' => '{"footer_description":"Lorem ipsum dolor sit amet, consect etur adi pisicing elit sed do eiusmod tempor incididunt ut labore.","newsletter_address":"88 Broklyn Golden Street, New York. USA needhelp@ziston.com","theme_color":"39089809809","new_account_button":"Register","new_account_url":"#","social":[{"icon":"ri:facebook-fill","link":"#"},{"icon":"ri:twitter-fill","link":"#"},{"icon":"ri:google-fill","link":"#"},{"icon":"ri:instagram-fill","link":"#"},{"icon":"ri:pinterest-fill","link":"#"}]}'),
        array('id' => '6','key' => 'seo_home','value' => '{"site_name":"Home","matatag":"Home","matadescription":"it is an payment gateway application. you can add your payment gateway keys,id and start using your payment gateway system within 5  within 5 minutes.","twitter_site_title":"home"}'),
        array('id' => '7','key' => 'seo_blog','value' => '{"site_name":"Blog","matatag":"Blog","matadescription":"it is an payment gateway application. in this page you can view all post recently post form the application","twitter_site_title":"Blog"}'),
        array('id' => '8','key' => 'seo_service','value' => '{"site_name":"Service","matatag":"Service","matadescription":"it is an payment gateway application. in this page you can view all details about each services","twitter_site_title":"Service"}'),
        array('id' => '9','key' => 'seo_contract','value' => '{"site_name":"Contract","matatag":"Contract","matadescription":"it is an payment gateway application. in this page you can view all Contract about the application system","twitter_site_title":"Contract"}'),
        array('id' => '10','key' => 'seo_pricing','value' => '{"site_name":"Pricing","matatag":"Pricing","matadescription":"it is an payment gateway application. in this page you can view all Contract about the application system","twitter_site_title":"Pricing"}'),
        array('id' => '11','key' => 'currency_symbol','value' => '$'),
        array('id' => '12','key' => 'hero_section','value' => '{"title":"Payments infrastructure for the internet","des":"Millions of companies of all sizes\\u2014from startups to Fortune 500s\\u2014use Stripe\\u2019s software and APIs to accept payments, send payouts, and manage their businesses online.","start_text":"Start Now","start_url":"http:\\\\/\\\\/google.com\\\\/","contact_text":"Contact Sales","contact_url":"http:\\\\/\\\\/google.com\\\\/","image":"uploads\\\\/hero_section\\\\/21\\\\/04\\\\/1698167161124161.png"}'),
        array('id' => '13','key' => 'tax','value' => '2'),

        array('id' => '14','key' => 'dns_settings','value' => '{"dns_configure_instruction":"You\'ll need to setup a DNS record to point to your store on our server. DNS records can be setup through your domain registrars control panel. Since every registrar has a different setup, contact them for assistance if you\'re unsure.","support_instruction":"DNS changes may take up to 48-72 hours to take effect, although it\'s normally a lot faster than that. You will receive a reply when your custom domain has been activated. Please allow 1-2 business days for this process to complete."}'),

        array('id' => '15','key' => 'currency','value' => 'USD'),

        array('id' => '16','key' => 'developer_instruction','value' => '{"db_migrate_fresh_with_demo":"It will re-install the database and reimport the demo also","db_migrate":"this action will install table if new table exist","remove_cache":"this action will remove your store cache","remove_storage":"this action will remove uploaded files in your"}'),

        array('id' => '17','key' => 'invoice_prefix','value' => '#AMC'),
        
        array('id' => '18','key' => 'automatic_renew_plan_mail','value' => '{"order_complete":"<b>Your subscription has been successfully renewed.</b><br> Your subscription automatic renewal order has been received and is now being processed. Your order details are shown below for your reference.","user_balance_low":"<b>We were unable to make renew your subscription plan.</b><br> Please top up the balance for renew the subscription. your subscription detail is shown below for your reference.","plan_disabled":"<b>We were unable to make renew your subscription plan.</b><br> Please change your subscription plan. Currently this plan not available or contact at the support forum."}'),
        array('id' => '19','key' => 'seo_gallery','value' => '{"site_name":"Gallery","matatag":"gallery","matadescription":"it is an payment gateway application. in this page you can view all Contract about the application system","twitter_site_title":"Pricing"}')
      );


          Option::insert($options);

          $plans = 
            [
              [
                "id" => 1,
                "name" => "free",
                "duration" => 15,
                "price" => 0,
                "status" => 1,
                "is_default" => 0,
                "is_featured" => 0,
                "is_trial" => 1,
                "data" => "{\"pos\": \"on\", \"pwa\": \"off\", \"barcode\": \"off\", \"qr_code\": \"off\", \"post_limit\": \"3\", \"sub_domain\": \"on\", \"custom_css_js\": \"on\", \"custom_domain\": \"off\", \"storage_limit\": \"500\", \"staff_limit\": \"2\", \"customer_modules\": \"on\", \"push_notification\": \"on\", \"image_optimization\": \"off\"}",
                "created_at" => "2021-05-03 09:54:28",
                "updated_at" => "2021-12-24 07:25:35"
              ],
              [
                "id" => 2,
                "name" => "prime",
                "duration" => 30,
                "price" => 9.99,
                "status" => 1,
                "is_default" => 0,
                "is_featured" => 1,
                "is_trial" => 0,
                "data" => "{\"pos\": \"on\", \"pwa\": \"off\", \"barcode\": \"off\", \"qr_code\": \"on\", \"post_limit\": \"50\", \"sub_domain\": \"on\", \"custom_css_js\": \"on\", \"custom_domain\": \"off\", \"storage_limit\": \"999\", \"staff_limit\": \"10\", \"customer_modules\": \"on\", \"push_notification\": \"on\", \"image_optimization\": \"off\"}",
                "created_at" => "2021-05-03 09:55:45",
                "updated_at" => "2021-12-24 07:45:19"
              ],
              [
                "id" => 3,
                "name" => "Standard",
                "duration" => 30,
                "price" => 19.99,
                "status" => 1,
                "is_default" => 0,
                "is_featured" => 1,
                "is_trial" => 0,
                "data" => "{\"pos\": \"on\", \"pwa\": \"on\", \"barcode\": \"on\", \"qr_code\": \"on\", \"post_limit\": \"100\", \"sub_domain\": \"on\", \"custom_css_js\": \"on\", \"custom_domain\": \"on\", \"storage_limit\": \"2599\", \"staff_limit\": \"30\", \"customer_modules\": \"on\", \"push_notification\": \"on\", \"image_optimization\": \"on\"}",
                "created_at" => "2021-12-24 06:01:50",
                "updated_at" => "2021-12-24 07:44:59"
              ]
            ];
   

          Plan::insert($plans);

        $services = 
      
          [
            [
              "id" => 5,
              "title" => "Quick Setup",
              "slug" => "quick-setup",
              "type" => "service",
              "status" => 1,
              "featured" => 0,
              "created_at" => "2021-12-07 22:18:06",
              "updated_at" => "2021-12-15 08:20:42"
            ],
            [
              "id" => 7,
              "title" => "Barcode Print",
              "slug" => "barcode-print",
              "type" => "service",
              "status" => 1,
              "featured" => 0,
              "created_at" => "2021-12-15 08:39:58",
              "updated_at" => "2021-12-15 08:39:58"
            ],
            [
              "id" => 8,
              "title" => "Custom Domain",
              "slug" => "custom-domain",
              "type" => "service",
              "status" => 1,
              "featured" => 0,
              "created_at" => "2021-12-15 08:56:34",
              "updated_at" => "2021-12-15 08:57:00"
            ],
            [
              "id" => 9,
              "title" => "POS System",
              "slug" => "pos-system",
              "type" => "service",
              "status" => 1,
              "featured" => 0,
              "created_at" => "2021-12-07 22:03:56",
              "updated_at" => "2021-12-15 08:30:37"
            ],
            [
              "id" => 10,
              "title" => "Broad beans, tomato, garlic & mozzarella cheese bruschetta",
              "slug" => "broad-beans-tomato-garlic-mozzarella-cheese-bruschetta",
              "type" => "blog",
              "status" => 1,
              "featured" => 1,
              "created_at" => "2021-12-24 10:32:16",
              "updated_at" => "2021-12-24 10:32:16"
            ],
            [
              "id" => 11,
              "title" => "Steak salad with goat cheese and arugula for your family?",
              "slug" => "steak-salad-with-goat-cheese-and-arugula-for-your-family",
              "type" => "blog",
              "status" => 1,
              "featured" => 1,
              "created_at" => "2021-12-24 10:41:52",
              "updated_at" => "2021-12-24 10:41:52"
            ],
            [
              "id" => 12,
              "title" => "Egg salad sandwich with avocado and watercress chip",
              "slug" => "egg-salad-sandwich-with-avocado-and-watercress-chip",
              "type" => "blog",
              "status" => 1,
              "featured" => 1,
              "created_at" => "2021-12-24 10:45:48",
              "updated_at" => "2021-12-24 10:46:07"
            ],
            [
              "id" => 13,
              "title" => "GrShop",
              "slug" => "grshop",
              "type" => "theme_demo",
              "status" => 1,
              "featured" => 0,
              "created_at" => "2022-02-17 17:05:41",
              "updated_at" => "2022-02-17 17:05:41"
            ],
            [
              "id" => 14,
              "title" => "Grocery",
              "slug" => "grocery",
              "type" => "theme_demo",
              "status" => 1,
              "featured" => 0,
              "created_at" => "2022-02-17 17:06:06",
              "updated_at" => "2022-02-17 17:06:06"
            ],
            [
              "id" => 15,
              "title" => "Foodfair",
              "slug" => "foodfair",
              "type" => "theme_demo",
              "status" => 1,
              "featured" => 0,
              "created_at" => "2022-02-17 17:06:22",
              "updated_at" => "2022-02-17 17:06:22"
            ]
            ];
      
        
        Term::insert($services);


        $servicemeta = 
          [
            [
              "id" => 4,
              "term_id" => 5,
              "key" => "service",
              "value" => "{\"short_content\":\"You can create your new restaurant's website in minutes & if you want you can be our partner.\",\"description\":\"Velit placeat conse\",\"image\":\"uploads\/service\/2021-12-15 08:48:45_serviceBcftHMpinQ.png\"}"
            ],
            [
              "id" => 8,
              "term_id" => 7,
              "key" => "service",
              "value" => "{\"short_content\":\"You can generate barcode for each product. You can add products in POS by barcode.\",\"description\":\"Barcode\",\"image\":\"uploads\/service\/2021-12-15 08:39:58_serviceoEt1N2dpVQ.png\"}"
            ],
            [
              "id" => 9,
              "term_id" => 8,
              "key" => "service",
              "value" => "{\"short_content\":\"You can add your own domain to your restaurant's website.  You can also use subdomain.\",\"description\":\"Domain\",\"image\":\"uploads\/service\/2021-12-15 08:56:34_serviceT2a7FrJWwe.png\"}"
            ],
            [
              "id" => 10,
              "term_id" => 9,
              "key" => "service",
              "value" => "{\"short_content\":\"Restaurants owner can create orders by POS. It will work invoice and you can print this invoice.\",\"description\":\"POS\",\"image\":\"uploads\/service\/2021-12-15 09:00:03_serviceBecZkSiJck.png\"}"
            ],
            [
              "id" => 11,
              "term_id" => 10,
              "key" => "excerpt",
              "value" => "While a logo might be the most recognizable manifestation of a brand, it’s only one of many."
            ],
            [
              "id" => 12,
              "term_id" => 10,
              "key" => "preview",
              "value" => "uploads/laravel/21/12/61c5a1b0401132412211640341936.jpg"
            ],
            [
              "id" => 13,
              "term_id" => 10,
              "key" => "description",
              "value" => "<p><span style=\"font-family: Montserrat, sans-serif;\">While a logo might be the most recognizable manifestation of a brand, it’s only one of many. Brands cut across media, and present themselves in colors, shapes, words, sounds, and even smells. That’s because a brand, at it’s core, is immaterial. It’s about abstract attributes and values which present themselves in concrete ways:While a logo might be the most recognizable manifestation of a brand, it’s only one of many. Brands cut across media, and present themselves in colors, shapes, words, sounds, and even smells. That’s because a brand, at it’s core, is immaterial. It’s about abstract attributes and values which present themselves in concrete ways:</span></p><p><span style=\"font-family: Montserrat, sans-serif;\">While a logo might be the most recognizable manifestation of a brand, it’s only one of many. Brands cut across media, and present themselves in colors, shapes, words, sounds, and even smells. That’s because a brand, at it’s core, is immaterial. It’s about abstract attributes and values which present themselves in concrete ways:While a logo might be the most recognizable manifestation of a brand, it’s only one of many. Brands cut across media, and present themselves in colors, shapes, words, sounds, and even smells. That’s because a brand, at it’s core, is immaterial. It’s about abstract attributes and values which present themselves in concrete ways:</span></p><p><span style=\"font-family: Montserrat, sans-serif;\"><br></span><br></p>"
            ],
            [
              "id" => 14,
              "term_id" => 11,
              "key" => "excerpt",
              "value" => "While a logo might be the most recognizable manifestation of a brand, it’s only one of many."
            ],
            [
              "id" => 15,
              "term_id" => 11,
              "key" => "preview",
              "value" => "uploads/laravel/21/12/61c5a3f06f9b42412211640342512.jpg"
            ],
            [
              "id" => 16,
              "term_id" => 11,
              "key" => "description",
              "value" => "<p class=\"blog-text mb-lg-5 mb-3\" style=\"outline: none; padding: 0px; line-height: 32px; font-family: Montserrat, sans-serif;\">Best is because a brand, at it’s core, is immaterial. It’s about abstract attributes and values which present themselves in concrete ways:While a logo might be the most recognizable manifestation of a brand, it’s only one of many. Brands cut across media, and present themselves in colors, shapes, words, sounds, and even smells. That’s because a brand, at it’s core, is immaterial. It’s about abstract attributes and values which present themselves in concrete ways:</p><p class=\"blog-text mb-lg-5 mb-3\" style=\"outline: none; padding: 0px; line-height: 32px; font-family: Montserrat, sans-serif;\">Brands cut across media, and present themselves in colors, shapes, words, sounds, and even smells. That’s because a brand, at it’s core, is immaterial. It’s about abstract attributes and values which present themselves in concrete ways:<br></p>"
            ],
            [
              "id" => 17,
              "term_id" => 12,
              "key" => "excerpt",
              "value" => "While a logo might be the most recognizable manifestation of a brand, it’s only one of many."
            ],
            [
              "id" => 18,
              "term_id" => 12,
              "key" => "preview",
              "value" => "uploads/laravel/21/12/61c5a4dc85a812412211640342748.jpg"
            ],
            [
              "id" => 19,
              "term_id" => 12,
              "key" => "description",
              "value" => "<p><span style=\"font-family: Montserrat, sans-serif;\">That’s because a brand, at it’s core, is immaterial. It’s about abstract attributes and values which present themselves in concrete ways:While a logo might be the most recognizable manifestation of a brand, it’s only one of many. Brands cut across media, and present themselves in colors, shapes, words, sounds, and even smells.</span></p><p class=\"blog-text mb-lg-5 mb-3\" style=\"outline: none; padding: 0px; line-height: 32px; font-family: Montserrat, sans-serif;\">Best is because a brand, at it’s core, is immaterial. It’s about abstract attributes and values which present themselves in concrete ways:While a logo might be the most recognizable manifestation of a brand, it’s only one of many. Brands cut across media, and present themselves in colors, shapes, words, sounds, and even smells. That’s because a brand, at it’s core, is immaterial. It’s about abstract attributes and values which present themselves in concrete ways:</p>"
            ],
            [
              "id" => 20,
              "term_id" => 13,
              "key" => "theme_demo",
              "value" => "{\"theme_url\":\"#\",\"theme_image\":\"demo620e8065f0d552022-02-17 17:05:41.png\"}"
            ],
            [
              "id" => 21,
              "term_id" => 14,
              "key" => "theme_demo",
              "value" => "{\"theme_url\":\"#\",\"theme_image\":\"demo620e807ecf2cf2022-02-17 17:06:06.png\"}"
            ],
            [
              "id" => 22,
              "term_id" => 15,
              "key" => "theme_demo",
              "value" => "{\"theme_url\":\"#\",\"theme_image\":\"demo620e808edc88e2022-02-17 17:06:22.png\"}"
            ]
          ];
    

        Termmeta::insert($servicemeta);

      $theme_settings = 
      [
        [
          "id" => 21,
          "key" => "theme",
          "value" => "{\"hero_img\":\"hero_img.png\",\"market_img\":\"market_img.png\",\"logo_img\":\"logo.png\",\"sell_img\":\"sell_img.jpg\",\"sell_url\":\"#\",\"market_url\":\"#\"}"
        ],
        [
          "id" => 22,
          "key" => "footer_theme",
          "value" => "{\"address\":\"1864 Lancaster Court Road Poughkeepsie, CA 12601\",\"email\":\"zoweramy@mailinator.com\",\"phone\":\"+1 (931) 943-1687\",\"copyright\":\"\u00a9 Copyright 2021, All Right Reserved\",\"social\":[{\"icon\":\"brandico:facebook\",\"link\":\"#\"},{\"icon\":\"ant-design:twitter-outlined\",\"link\":\"#\"},{\"icon\":\"ant-design:instagram-outlined\",\"link\":\"#\"},{\"icon\":\"ant-design:github-filled\",\"link\":\"#\"}]}"
        ],
        [
          "id" => 23,
          "key" => "languages",
          "value" => "{\"en\":\"English\"}"
        ],
        [
          "id" => 25,
          "key" => "active_languages",
          "value" => "{\"en\":\"English\"}"
        ]
        ];
      

      Option::insert($theme_settings);
          
    }
}
