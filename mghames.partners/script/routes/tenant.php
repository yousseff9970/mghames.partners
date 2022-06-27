<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;
use App\Jobs\TenantMailJob;
/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/


// tenant routes

Route::group(['middleware' => ['Isinstalled','InitializeTenancyByDomain','PreventAccessFromCentralDomains','web','tenantenvironment']], function () {
    Auth::routes();

    
    Route::get('/pwa',function(){
        return redirect('/'); 
    });

    //ecommerce routes for public
    
    Route::get('/', 'Store\PageController@home');

    
    Route::get('/products', 'Store\PageController@products');
    Route::get('/brand/{slug}', 'Store\PageController@brand');
    Route::get('/category/{slug}', 'Store\PageController@category');
    Route::get('/deals', 'Store\PageController@deals');
    Route::get('/featured/{slug}', 'Store\PageController@featured');
    Route::get('/tag/{slug}', 'Store\PageController@tag');
    Route::get('/product/{slug}', 'Store\PageController@productView');
    Route::get('/page/{slug}', 'Store\PageController@page');
    Route::get('/menu', 'Store\PageController@menu');
    Route::get('/cart', 'Store\PageController@cart');
    Route::get('/wishlist', 'Store\PageController@wishlist');
    Route::get('/checkout', 'Store\PageController@checkout');
    Route::get('/thanks', 'Store\PageController@thanks');
    Route::post('make-order', 'Store\OrderController@makeOrder')->name('make.order');
    Route::get('/contact', 'Store\PageController@contact');
    Route::post('/contact/send', 'Store\PageController@contact_send')->middleware('throttle:2,1');
    Route::get('locale/lang', 'LocalizationController@store')->name('language.set');
    Route::get('category/product/show','Store\PageController@category_product')->name('category.product');

    Route::get('blog', 'Store\BlogController@index');
    Route::get('blog/{slug}', 'Store\BlogController@show');

    //cart routes
    Route::post('add-to-cart','Store\CartController@addtocart')->name('add.tocart');
    Route::post('add-to-wishlist','Store\CartController@addtowishlist')->name('add.wishlist');
    Route::post('makediscount','Store\CartController@makediscount')->name('makediscount');
    Route::get('remove-wishlist/{id}','Store\CartController@removeWishlist');
    Route::get('/express','Store\CartController@express');
    
   
    Route::get('remove-cart/{id}','Store\CartController@removecart')->name('remove.cart');
    Route::post('cart-qty','Store\CartController@CartQty')->name('cart.qty');
    Route::post('product-search','Store\CartController@search')->name('pos.search');
    Route::get('product-varidation/{id}','Store\CartController@varidation')->name('pos.varidation');
    Route::resource('order', 'Store\OrderController');
    Route::post('orders/destroy','Store\OrderController@destroy')->name('order.multipledelete');

    //routes for get response data
    Route::get('/databack', 'Store\DataController@databack');
    Route::get('/get-databack', 'Store\DataController@getData')->name('callback.data');
    Route::get('/get-product','Store\DataController@getproducts');
    Route::get('/get-product-reviews/{id}','Store\DataController@getProductReviews');
    Route::get('/product-details/{id}','Store\DataController@productDetails');
    Route::get('product_search','Store\DataController@productSearch')->name('product.search');

    Route::get('/order-success','Store\OrderController@success');
    Route::get('/order-fail','Store\OrderController@fail');
    

    //ecommerce store customers routes
    Route::group(['prefix'=>'customer'],function(){
        Route::post('/make-subscribe','Store\CustomerController@subscribe')->name('customer.subscribe');
        Route::get('/login', 'Store\CustomerController@login')->middleware('guest');
        Route::get('/register', 'Store\CustomerController@register')->middleware('guest');
        Route::post('/register-customer', 'Store\CustomerController@registerCustomer')->name('customer.register')->middleware('guest');
        Route::get('/dashboard', 'Store\CustomerController@dashboard')->middleware(['auth','user']);
        Route::get('/orders', 'Store\CustomerController@orders')->middleware(['auth','user']);
        Route::get('/order/{id}', 'Store\CustomerController@orderview')->middleware(['auth','user']);
        Route::get('/settings', 'Store\CustomerController@settings')->middleware(['auth','user']);
        Route::get('/reviews', 'Store\CustomerController@reviews')->middleware(['auth','user']);
        Route::post('profile/update','Store\CustomerController@profileUpdate')->name('customer.profile.update')->middleware(['auth','user']);
        Route::post('profile/password-update','Store\CustomerController@profilePasswordUpdate')->name('customer.password.update')->middleware(['auth','user']);
        Route::post('order-make-rating/{orderid}/{termid}/{optionid}','Store\CustomerController@makeReview')->middleware(['auth','user']);
        
    });
    


   



    Route::post('save-token','Seller\FirebaseController@saveToken')->name('save-token')->middleware(['auth','user']);

    Route::get('/oops', function () {
        return "this modules not support for this request";
    });
    Route::get('/reset/product-price','CronController@ProductPriceReset');

    Route::get('/mysettings', 'Admin\UserController@index')->middleware(['auth','user']);
    Route::post('genup', 'Admin\UserController@genUpdate')->name('admin.users.genupdate')->middleware(['auth','user']);
    Route::post('passup', 'Admin\UserController@updatePassword')->name('admin.users.passup')->middleware(['auth','user']); 
    Route::get('/make-login/{token}','Seller\LoginController@tokenBasedLogin')->middleware('throttle:2,1');
    Route::get('redirect/login', 'Seller\LoginController@login');
   

   

    
});





