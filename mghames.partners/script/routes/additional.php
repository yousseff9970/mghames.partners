<?php 
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;


//**======================== Payment Gateway Route Group for merchant ====================**//
Route::group(['domain' => env('APP_URL'),'middleware' => ['auth', 'web']], function () {
    Route::get('/payment/paypal', '\App\Lib\Paypal@status');
    Route::post('/stripe/payment', '\App\Lib\Stripe@status')->name('stripe.payment');
    Route::get('/stripe', '\App\Lib\Stripe@view')->name('stripe.view');
    Route::get('/payment/mollie', '\App\Lib\Mollie@status');
    Route::post('/payment/paystack', '\App\Lib\Paystack@status');
    Route::get('/partner/paystack', '\App\Lib\Paystack@view')->name('merchant.paystack.view');
    Route::get('/mercadopago/pay', '\App\Lib\Mercado@status')->name('merchant.mercadopago.status');
    Route::get('partner/tap/view/{from}', '\App\Lib\Tap@view')->name('merchant.tap.view');
    Route::get('/payment/tap/', '\App\Lib\Tap@status')->name('merchant.tap.status');
    Route::post('/payment/tap/authorize', '\App\Lib\Tap@authorize')->name('merchant.tap.authorize');
    Route::get('/razorpay/payment', '\App\Lib\Razorpay@view')->name('razorpay.view');
    Route::post('partner/razorpay/status', '\App\Lib\Razorpay@status');
    Route::get('/payment/flutterwave', '\App\Lib\Flutterwave@status');
    Route::get('/payment/thawani', '\App\Lib\Thawani@status');
    Route::get('/payment/instamojo', '\App\Lib\Instamojo@status');
    Route::get('/payment/toyyibpay', '\App\Lib\Toyyibpay@status');
    Route::get('/payment/hyperpay', '\App\Lib\Hyperpay@status');
    Route::get('/partner/razorpay/payment', '\App\Lib\Hyperpay@view');
    Route::get('/manual/payment', '\App\Lib\CustomGetway@status');
    Route::get('payu/payment', '\App\Lib\Payu@view')->name('payu.view');
    Route::post('partner/payu/status', '\App\Lib\Payu@status')->name('merchant.payu.status');
});

Route::group(['middleware' => ['web','InitializeTenancyByDomain','PreventAccessFromCentralDomains','web','tenantenvironment']], function () {
    Route::get('/order/payment/paypal', '\App\Lib\Paypal@status');
    Route::post('/stripe/payment', '\App\Lib\Stripe@status')->name('order.stripe.payment');
    Route::get('/order/stripe', '\App\Lib\Stripe@view')->name('order.stripe.view');
    Route::get('/order/payment/mollie', '\App\Lib\Mollie@status');

    Route::post('/order/paystack-status', '\App\Lib\Paystack@status')->name('order.paystack.payment');
    Route::get('/order/paystack', '\App\Lib\Paystack@view')->name('order.paystack.view');

    Route::get('/order/mercadopago/pay', '\App\Lib\Mercado@status')->name('order.mercadopago.status');
    Route::get('partner/tap/view/{from}', '\App\Lib\Tap@view')->name('merchant.tap.view');
    Route::get('/payment/tap/', '\App\Lib\Tap@status')->name('merchant.tap.status');
    Route::post('/payment/tap/authorize', '\App\Lib\Tap@authorize')->name('merchant.tap.authorize');

    Route::get('/order/razorpay/payment', '\App\Lib\Razorpay@view')->name('order.razorpay.view');
    Route::post('order/razorpay/status', '\App\Lib\Razorpay@status')->name('order.razorpay.payment');

    Route::get('/order/payment/flutterwave', '\App\Lib\Flutterwave@status');

    Route::get('/order/payment/thawani', '\App\Lib\Thawani@status');

    Route::get('/order/payment/instamojo', '\App\Lib\Instamojo@status');
    
    Route::get('/order/payment/toyyibpay', '\App\Lib\Toyyibpay@status');

    Route::get('/payment/hyperpay', '\App\Lib\Hyperpay@status');
    Route::get('/partner/razorpay/payment', '\App\Lib\Hyperpay@view');
    Route::get('/manual/payment', '\App\Lib\CustomGetway@status');
    Route::get('/order/payment/payu', '\App\Lib\Payu@view')->name('payu.view');
    Route::post('partner/payu/status', '\App\Lib\Payu@status')->name('merchant.payu.status');
});

