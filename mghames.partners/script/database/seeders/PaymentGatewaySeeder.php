<?php

namespace Database\Seeders;

use App\Models\Getway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $getways = array(
            array('id' => '1','name' => 'paypal','logo' => 'uploads/21/04/1698367938881552.png','rate' => '1','charge' => '2','namespace' => 'App\\Lib\\Paypal','currency_name' => 'USD','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '0','data' => '{"client_id":"ARKsbdD1qRpl3WEV6XCLuTUsvE1_5NnQuazG2Rvw1NkMG3owPjCeAaia0SXSvoKPYNTrh55jZieVW7xv","client_secret":"EJed2cGACzB2SJFQwSannKAA1gyBjKkwlKh1o8G75zQHYzAgLQ3n7f9EfeNCZgtfPDMxyFzfp6oQWPia"}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-04-29 09:51:23'),
            array('id' => '2','name' => 'stripe','logo' => 'uploads/21/04/1698367948712217.png','rate' => '10','charge' => '2','namespace' => 'App\\Lib\\Stripe','currency_name' => 'usd','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '0','data' => '{"publishable_key":"pk_test_51I8GqvBRq7fsgmoHB37mXDC3oNVtsJBMQRYeRLUykmuWlqihZ1kDvYeLUeno9Nkqze4axZF0nLeeqkdYJP42S06u00GEiuG8CS","secret_key":"sk_test_51I8GqvBRq7fsgmoHldttMcxnaiSwu5thxGVELXwxd9la5NNttvNBICXTY7r0TkTEDKqzdIl9KZIJu6sNMJqMM1MZ00I8obAU6P"}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-04-29 09:51:32'),
            array('id' => '3','name' => 'mollie','logo' => 'uploads/21/04/1698367959065956.png','rate' => '10','charge' => '2','namespace' => 'App\\Lib\\Mollie','currency_name' => 'usd','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '0','data' => '{"api_key":"test_WqUGsP9qywy3eRVvWMRayxmVB5dx2r"}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-05-01 16:29:00'),
            array('id' => '4','name' => 'paystack','logo' => 'uploads/21/04/1698367968509154.png','rate' => '10','charge' => '2','namespace' => 'App\\Lib\\Paystack','currency_name' => 'NGN','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '0','data' => '{"public_key":"pk_test_84d91b79433a648f2cd0cb69287527f1cb81b53d","secret_key":"sk_test_cf3a234b923f32194fb5163c9d0ab706b864cc3e"}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-05-01 16:44:01'),
            array('id' => '5','name' => 'razorpay','logo' => 'uploads/21/04/1698367977941644.png','rate' => '10','charge' => '2','namespace' => 'App\\Lib\\Razorpay','currency_name' => 'INR','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '0','data' => '{"key_id":"rzp_test_siWkeZjPLsYGSi","key_secret":"jmIzYyrRVMLkC9BwqCJ0wbmt"}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-04-29 09:52:00'),
            array('id' => '6','name' => 'instamojo','logo' => 'uploads/21/04/1698367990639996.png','rate' => '54','charge' => '2','namespace' => 'App\\Lib\\Instamojo','currency_name' => 'INR','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '1','data' => '{"x_api_key":"test_0027bc9da0a955f6d33a33d4a5d","x_auth_token":"test_211beaba149075c9268a47f26c6"}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-04-29 09:52:12'),
            array('id' => '7','name' => 'toyyibpay','logo' => 'uploads/21/04/1698368000180467.png','rate' => '54','charge' => '2','namespace' => 'App\\Lib\\Toyyibpay','currency_name' => 'MR','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '1','data' => '{"user_secret_key":"v4nm8x50-bfb4-7f8y-evrs-85flcysx5b9p","cateogry_code":"5cc45t69"}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-04-29 09:52:21'),
            array('id' => '8','name' => 'flutterwave','logo' => 'uploads/21/04/1698368012665741.png','rate' => '54','charge' => '2','namespace' => 'App\\Lib\\Flutterwave','currency_name' => 'NGN','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '1','data' => '{"public_key":"FLWPUBK_TEST-f448f625c416f69a7c08fc6028ebebbf-X","secret_key":"FLWSECK_TEST-561fa94f45fc758339b1e54b393f3178-X","encryption_key":"FLWSECK_TEST498417c2cc01","payment_options":"card"}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-04-29 09:52:33'),
            array('id' => '9','name' => 'payu','logo' => 'uploads/21/04/1698368022202232.png','rate' => '54','charge' => '2','namespace' => 'App\\Lib\\Payu','currency_name' => 'INR','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '1','data' => '{"merchant_key":"IPeQuHyk","merchant_salt":"YsfnYBVxYI","auth_header":"VHgXMklEVpktkIZjOZjdUJKPdSPe+c5iICxOFwaC9T0="}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-04-29 09:52:42'),
            array('id' => '10','name' => 'thawani','logo' => 'uploads/21/04/1698368032853372.png','rate' => '0.38','charge' => '1','namespace' => 'App\\Lib\\Thawani','currency_name' => 'OMR','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '1','data' => '{"secret_key":"rRQ26GcsZzoEhbrP2HZvLYDbn9C9et","publishable_key":"HGvTMLDssJghr9tlN9gr4DVYt0qyBy"}','created_at' => '2021-04-15 02:44:46','updated_at' => '2021-05-01 16:59:36'),
            array('id' => '11','name' => 'manual','logo' => 'uploads/21/04/1698368040658664.png','rate' => '1','charge' => '1','namespace' => 'App\\Lib\\CustomGetway','currency_name' => 'USD','is_auto' => '0','image_accept' => '1','test_mode' => '1','status' => '1','phone_required' => '0','data' => '','created_at' => '2021-04-15 04:12:12','updated_at' => '2021-04-29 09:53:00'),
            array('id' => '12','name' => 'mercadopago','logo' => 'uploads/21/04/1698368050865604.png','rate' => '1.2','charge' => '1','namespace' => 'App\\Lib\\Mercado','currency_name' => 'USD','is_auto' => '1','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '0','data' => '{"secret_key":"TEST-1884511374835248-071019-698f8465954d5983722e8b4d7a05f1ca-370993848","public_key":"TEST-7d239fd1-3c41-4dc0-96eb-f759b7d2adab"}','created_at' => '2021-04-15 05:40:51','updated_at' => '2021-04-29 09:53:09'),
            array('id' => '13','name' => 'free','logo' => NULL,'rate' => '1','charge' => '0','namespace' => '','currency_name' => '','is_auto' => '0','image_accept' => '0','test_mode' => '1','status' => '1','phone_required' => '0','data' => '','created_at' => NULL,'updated_at' => NULL),
            array('id' => '14','name' => 'my credits','logo' => NULL,'rate' => '1','charge' => '0','namespace' => 'App\\Lib\\Credit','currency_name' => 'USD','is_auto' => '1','image_accept' => '0','test_mode' => '0','status' => '1','phone_required' => '0','data' => '','created_at' => '2021-04-15 05:40:51','updated_at' => '2021-04-29 09:53:09')
        );               
        Getway::insert($getways);
    }
}
