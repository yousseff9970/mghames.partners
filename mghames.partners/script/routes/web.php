<?php

use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('cache-clear',function(){
   Artisan::call('cache:clear'); 
   Artisan::call('config:clear'); 
});

Route::get('php-info',function(){
  phpinfo();
});


// Match my own domain
Route::group(['domain' => env('APP_URL')], function($domain)
{

    Auth::routes();

    Route::get('/','WelcomeController@index')->name('welcome');
    Route::get('blog/{title}','BlogController@show')->name('blog.show');
    Route::get('blogs/search','BlogController@search')->name('blog.search');
    Route::get('blogs','BlogController@lists')->name('blog.lists');
    Route::get('page/{slug}','PageController@show')->name('page.show');
    Route::get('contact','ContactController@index')->name('contact.index');
    Route::post('contact/send','ContactController@send')->name('contact.send')->middleware('throttle:2,1');
    Route::get('pricing','PricingController@index')->name('princing.index');
    Route::get('demos','WelcomeController@demos')->name('demos');
    Route::post('lang/switch','WelcomeController@lang_switch')->name('lang.switch');

    Route::post('subscribe','WelcomeController@subscribe')->name('subscribe');
    Route::get('register','RegisterController@index')->name('user.register')->middleware('guest');
    Route::get('user/login','RegisterController@login')->name('user.login')->middleware('guest');
    Route::post('user/store','RegisterController@store')->name('user.store')->middleware('guest');

    // **---------------------------------------CRON JOB ROUTES START---------------------------------------** //

    //automatic charge from the credits
    Route::get('cron/make-charge', 'CronController@makeCharge');
    // Alert after Order Expired
    Route::get('cron/alert-user/after/order/expired', 'CronController@alertUserAfterExpiredOrder')->name('alert.after.order.expired');
    // Alert before Order Expired
    Route::get('cron/alert-user/before/order/expired', 'CronController@alertUserBeforeExpiredOrder')->name('alert.before.order.expired');
    Route::get('cron/tenant-reset-product-price', 'CronController@tenantPricereset');


     Route::get('/sitemap.xml', 'SettingController@sitemapView');
     Route::get('locale/lang', 'LocalizationController@store')->name('language.set');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/mysettings', 'Admin\UserController@index')->name('admin.admin.mysettings')->middleware('auth');
    Route::post('genup', 'Admin\UserController@genUpdate')->name('admin.users.genupdate')->middleware('auth');
    Route::post('passup', 'Admin\UserController@updatePassword')->name('admin.users.passup')->middleware('auth');

    Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin','user']], function () {
        Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
        Route::get('/dashboard/static','DashboardController@staticData');
        Route::get('/dashboard/perfomance/{period}','DashboardController@perfomance');
        Route::get('/dashboard/deposit/perfomance/{period}','DashboardController@depositPerfomance');
        Route::get('/dashboard/order_statics/{month}','DashboardController@order_statics');
        Route::get('/dashboard/visitors/{days}','DashboardController@google_analytics');
        Route::resource('cron', 'CronController');

        Route::resource('store', 'StoreController');
        Route::post('stores/destroys', 'StoreController@destroy')->name('stores.destroys');

        Route::resource('domain', 'DomainController');
        Route::post('domains/destroys', 'DomainController@destroy')->name('domains.destroys');

        Route::get('domain/edit/database/{id}', 'StoreController@databaseView')->name('domain.database.edit');
        Route::put('domain/update/database/{id}', 'StoreController@databaseUpdate')->name('database.update');
        Route::get('domain/edit/plan/{id}', 'StoreController@planView')->name('domain.plan.edit');
        Route::put('domain/update/plan/{id}', 'StoreController@planUpdate')->name('domain.plan.update');

        Route::resource('seo', 'SeoController');

        Route::resource('env', 'EnvController');
        Route::get('site/settings', 'EnvController@theme_settings')->name('site.settings');

        Route::resource('plan', 'PlanController');
        Route::post('plans/delete', 'PlanController@destroy')->name('plans.destroys');
        Route::get('/plan/config/settings','PlanController@settings')->name('plan.settings');
        Route::put('/plan/config/update/{type}','PlanController@settingsUpdate')->name('plan.settings.update');

        //language
        Route::resource('language', 'LanguageController');
        Route::get('languages/delete/{id}', 'LanguageController@destroy')->name('languages.delete');
        Route::post('languages/setActiveLanuguage', 'LanguageController@setActiveLanuguage')->name('languages.active');
        Route::post('languages/add_key', 'LanguageController@add_key')->name('language.add_key');
        // Menu Route
        Route::resource('menu', 'MenuController');
        Route::post('/menus/destroy', 'MenuController@destroy')->name('menus.destroy');
        Route::post('menues/node', 'MenuController@MenuNodeStore')->name('menus.MenuNodeStore');
        //role routes
        Route::resource('role', 'RoleController');
        Route::post('roles/destroy', 'RoleController@destroy')->name('roles.destroy');
        // Admin Route
        Route::resource('admin', 'AdminController');
        Route::post('/admins/destroy', 'AdminController@destroy')->name('admins.destroy');

        //Gateway crud controller
        Route::resource('gateway', 'PaymentGatewayController');
        //Blog crud controller
        Route::resource('blog', 'BlogController');
        //Page crud controller
        Route::resource('page', 'PageController');

        Route::resource('template','ThemeController');

        Route::get('/dns/settings', 'StoreController@dnsSettingView')->name('dns.settings');
        Route::put('/dns/update', 'StoreController@dnsUpdate')->name('dns.update');

        Route::get('/developer/instruction', 'StoreController@instructionView')->name('developer.instruction');
        Route::put('/instruction/update', 'StoreController@instructionUpdate')->name('developer.instruction.update');

        //Support Route
        Route::resource('support', 'SupportController');
        Route::post('supportInfo', 'SupportController@getSupportData')->name('support.info');
        Route::post('supportstatus', 'SupportController@supportStatus')->name('support.status');

        //Option route
        Route::get('option/edit/{key}', 'OptionController@edit')->name('option.edit');
        Route::post('option/update/{key}', 'OptionController@update')->name('option.update');
        Route::get('option/sco-index', 'OptionController@seoIndex')->name('option.seo-index');
        Route::get('option/seo-edit/{id}', 'OptionController@seoEdit')->name('option.seo-edit');
        Route::put('option/seo-update/{id}', 'OptionController@seoUpdate')->name('option.seo-update');


        //Theme settings
        Route::get('theme/settings', 'OptionController@settingsEdit')->name('theme.settings');
        Route::put('theme/settings-update/{id}', 'OptionController@settingsUpdate')->name('theme.settings.update');
        Route::get('theme/settings/General','ThemesettingsController@general')->name('settings.general');
        Route::post('theme/settings/General','ThemesettingsController@generalupdate')->name('settings.general.update');
        Route::get('theme/settings/services','ThemesettingsController@serviceindex')->name('settings.service.index');
        Route::get('theme/settings/services/create','ThemesettingsController@servicecreate')->name('settings.service.create');
        Route::post('theme/settings/services/store','ThemesettingsController@servicestore')->name('settings.service.store');
        Route::get('theme/settings/services/{id}/edit','ThemesettingsController@serviceedit')->name('settings.service.edit');
        Route::put('theme/settings/services/update/{id}','ThemesettingsController@serviceupdate')->name('settings.service.update');
        Route::post('theme/settings/services/destroy','ThemesettingsController@servicedestroy')->name('settings.service.destroy');
        Route::get('theme/footer','ThemesettingsController@footerindex')->name('settings.footer.index');
        Route::post('theme/settings/footer','ThemesettingsController@footerupdate')->name('settings.footer.update');
        Route::get('theme/settings/themes','ThemesettingsController@demo_lists')->name('settings.demo');
        Route::get('theme/settings/theme/create','ThemesettingsController@demo_create')->name('settings.demo.create');
        Route::post('theme/settings/theme/create','ThemesettingsController@demo_store')->name('settings.demo.store');
        Route::get('theme/settings/theme/{id}/edit','ThemesettingsController@demo_edit')->name('settings.demo.edit');
        Route::put('theme/settings/theme/update/{id}','ThemesettingsController@demo_update')->name('settings.demo.update');
        Route::post('theme/settings/theme/destroy','ThemesettingsController@demo_destroy')->name('settings.demo.destroy');


        //Order Route
        Route::resource('order', 'OrderController');

        //merchant crud and mail controller
        Route::resource('partner', 'MerchantController');
        Route::post('merchant-send-mail/{id}', 'MerchantController@sendMail');
        Route::get('merchant-login/{id}', 'MerchantController@login')->name('merchant.login');


        //Report Route
        Route::resource('report', 'ReportController');
        Route::get('order-excel', 'ReportController@excel')->name('order.excel');
        Route::get('order-csv', 'ReportController@csv')->name('order.csv');
        Route::get('order-pdf', 'ReportController@pdf')->name('order.pdf');
        Route::get('report-invoice/{id}', 'ReportController@invoicePdf')->name('report.pdf');

        // Fund History Route
        Route::get('fund/history','FundController@history')->name('fund.history');
        Route::post('fund/approved','FundController@approved')->name('fund.approved');
        Route::post('fund/store','FundController@store')->name('fund.store');

        // Theme Settings

    });


    Route::group(['prefix' => 'partner', 'as' => 'merchant.', 'namespace' => 'Merchant', 'middleware' => ['auth', 'merchant','user']], function () {
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('/dashboard-data','DashboardController@staticData');

        Route::get('domain', 'DomainController@index')->name('domain.list');
        Route::get('domain/create','DomainController@create')->name('domain.create');
        Route::get('domain/edit/{id}', 'DomainController@edit')->name('domain.edit');
        Route::put('domain/update/{id}', 'DomainController@update')->name('domain.update');
        Route::post('domain/check','DomainController@check')->name('domain.check');
        Route::post('domain/store','DomainController@store')->name('domain.store');
        Route::get('domain/select/plan','DomainController@gateway')->name('domain.payment');

        Route::get('domain/configuration/{id}', 'DomainController@domainConfig')->name('domain.domainConfig');
        Route::post('domain/add-subdomain/{id}','DomainController@addSubdomain')->name('add.subdomain');
        Route::put('domain/update-subdomain/{id}','DomainController@updateSubdomain')->name('update.subdomain');
        Route::delete('domain/delete-subdomain/{id}','DomainController@destroy')->name('destroy.subdomain');


        Route::post('domain/add-customdomain/{id}','DomainController@addCustomDomain')->name('add.customdomain');
        Route::put('domain/update-customdomain/{id}','DomainController@updateCustomDomain')->name('update.customdomain');
        Route::delete('domain/delete-customdomain/{id}','DomainController@destroyCustomdomain')->name('destroy.customdomain');

        Route::get('/domain/transfer/{id}','DomainController@transferView')->name('domain.transfer');
        Route::post('/domain/otp/{id}','DomainController@sendOtp')->name('domain.transfer.otp')->middleware('throttle:5,1');
        Route::post('/domain/varifyotp/{id}','DomainController@verifyOtp')->name('domain.verify.otp')->middleware('throttle:5,1');

        Route::get('/domain/developer-mode/{id}','DomainController@developerView')->name('domain.developer');
        Route::post('/domain/migrate-seed/{id}','DomainController@migrateWithSeed')->name('domain.migrate-seed');
        Route::post('/domain/migrate/{id}','DomainController@migrate')->name('domain.migrate');
        Route::post('/domain/clear-cache/{id}','DomainController@cacheClear')->name('domain.clear-cache');
        Route::post('/domain/remove-storage/{id}','DomainController@removeStorage')->name('domain.storage.clear');
        Route::post('/domain/login/{id}','DomainController@login')->name('domain.login');
        Route::post('/domain-login/{id}','DomainController@loginByDomain')->name('domain.login.domain');

        Route::get('/domain/renew/{id}','PlanController@renewView')->name('domain.renew');
        Route::get('/plan/domain/{id}','PlanController@changePlan')->name('domain.plan');
        Route::get('/plancharge/{domain}/{id}', 'PlanController@ChanePlanGateways')->name('plan.gateways');
        Route::post('/domain/renewcharge/{id}','PlanController@renewCharge')->name('plan.renew-plan');

        Route::get('/gateways/{id}', 'PlanController@gateways')->name('plan.gateways');
        Route::post('/deposit', 'PlanController@deposit')->name('plan.deposit');
        Route::get('plan-invoice/{id}', 'PlanController@invoicePdf');
        Route::resource('plan', 'PlanController');
        Route::get('enroll', 'PlanController@enroll')->name('plan.enroll');
        Route::post('enroll/store', 'PlanController@storePlan')->name('enroll.domain');

        // Store Create
        Route::get('store/create','PlanController@strorecreate')->name('plan.strorecreate');

        //Payment status route
        Route::get('payment/success', 'PlanController@success')->name('payment.success');
        Route::get('payment/failed', 'PlanController@failed')->name('payment.failed');
        //Support Route
        Route::resource('support', 'SupportController');

        //Report Route
        Route::resource('report', 'ReportController');

        // Fund Route
        Route::resource('fund','FundController');
        Route::get('fund/payment/select','FundController@payment')->name('fund.payment');
        Route::post('fund/deposit','FundController@deposit')->name('fund.deposit');
        Route::get('fund/history/list','FundController@history')->name('fund.history');

        Route::get('fund/redirect/success', 'FundController@success')->name('fund.success');
        Route::get('fund/redirect/fail', 'FundController@fail')->name('fund.fail');

        Route::get('plan-renew/redirect/success','PlanController@renewSuccess');
        Route::get('plan-renew/redirect/fail','PlanController@renewFail');

        // Lock Store
        Route::get('store/lock/{id}','PlanController@lock')->name('store.lock');

        // Order Routes
        Route::get('order','OrderController@index')->name('order.index');
    });

});








Route::group(['as' => 'seller.', 'prefix' => 'seller', 'namespace' => 'Seller', 'middleware' => ['InitializeTenancyByDomain','PreventAccessFromCentralDomains','auth','seller','user','tenantenvironment']], function () {
    Route::get('/dashboard', 'DashboardController@dashboard');
    Route::get('/dashboard/static','DashboardController@staticData');
    Route::get('/dashboard/perfomance/{period}','DashboardController@perfomance');
    Route::get('/dashboard/order-perfomance/{period}','DashboardController@orderPerfomace');
    
    Route::get('/dashboard/deposit/perfomance/{period}','DashboardController@depositPerfomance');
    Route::get('/dashboard/order_statics/{month}','DashboardController@order_statics');
    Route::get('/dashboard/neworders','DashboardController@getCurrentOrders')->name('orders.new');
    Route::get('/clear-cache','DashboardController@cacheClear');
    Route::get('/subscription-status','DashboardController@subscriptionStatus');
    

    Route::resource('category', 'CategoryController');
    Route::resource('brand', 'BrandController');
    Route::resource('tag', 'TagController');
    Route::resource('orderstatus', 'OrderstatusController');
    Route::resource('coupon', 'CouponController');
    Route::resource('tax', 'TaxController');
    Route::resource('location', 'LocationController');
    Route::resource('shipping', 'ShippingController');
    Route::resource('features', 'FeaturesController');
    Route::resource('product', 'ProductController');
    Route::post('product-import', 'ProductController@import')->name('product.import');
    Route::get('product/edit/{id}/{type}', 'ProductController@edit');
    Route::post('products/destroys', 'ProductController@multiDelete')->name('products.destroys');
    Route::resource('attribute', 'AttributeController');
    Route::resource('media', 'MediaController');
    Route::resource('mediacompress', 'ImagecompressController');
    Route::resource('table','TableController');
    Route::resource('barcode','BarcodeController');
    Route::get('barcodes/reset','BarcodeController@reset')->name('barcode.reset');
    Route::resource('user','UserController');
    Route::get('/user/login/{id}','UserController@login')->name('user.login');
    Route::resource('rider','RiderController');
    Route::get('settings','SettingsController@index');
    Route::post('settings/update','SettingsController@update')->name('settings.update');
    Route::get('medias','MedialistController@index');
    Route::post('media/delete','MedialistController@delete')->name('medias.delete');
    Route::get('media/create','MedialistController@create')->name('medias.create');

    Route::get('payment/gateway','PaymentgatewayController@index')->name('payment.gateway');
    Route::post('payment/custom/gateway','PaymentgatewayController@custom_payment')->name('custom.payment');
    Route::get('payment/custom/gateway/create','PaymentgatewayController@custom_payment_create')->name('custom.payment.create');
    Route::post('payment/gateway/{id}','PaymentgatewayController@store')->name('payment.gateway.store');
    Route::get('payment/gateway/{payment}','PaymentgatewayController@payment_edit')->name('payment.edit');
    Route::get('payment/install/{payment}','PaymentgatewayController@install')->name('payment.install');

    Route::get('theme','ThemeController@index')->name('theme.index');
    Route::get('theme/install/{theme}','ThemeController@install')->name('theme.install');

    Route::resource('language','LanguageController');
    Route::post('language-addkey/{id}','LanguageController@addKey')->name('language.addkey');
    Route::delete('language-remove-key/{id}','LanguageController@keyRemove')->name('language.keyremove');
    

    Route::get('calender','CalenderController@index')->name('calender.index');

    Route::get('upcominOrders','CalenderController@upcoming_orders')->name('seller.order.upcoming');

    Route::post('product/barcode/search','BarcodeController@search')->name('barcode.search');
    Route::post('barcode/generate','BarcodeController@generate')->name('barcode.generate');

    // Reviews Route
    Route::get('review','ReviewController@index')->name('review.index');
    Route::post('review/destroy','ReviewController@destroy')->name('review.destroy');

    //pos routes
    Route::resource('pos', 'PosController');
    Route::get('products','PosController@productList')->name('product.json');
    Route::post('add-to-cart','PosController@addtocart')->name('add.tocart');
    Route::get('remove-cart/{id}','PosController@removecart')->name('remove.cart');
    Route::post('cart-qty','PosController@CartQty')->name('cart.qty');
    Route::post('product-search','PosController@search')->name('pos.search');
    Route::get('product-varidation/{id}','PosController@varidation')->name('pos.varidation');
    Route::post('check-customer','PosController@checkcustomer');
    Route::post('make-order','PosController@makeorder')->name('pos.order');
    Route::post('make-customer','PosController@makeCustomer')->name('pos.customer.store');
    Route::get('apply-tax','PosController@applyTax');
    Route::resource('order', 'OrderController');
    Route::post('orders/destroy','OrderController@destroy')->name('order.multipledelete');

    Route::get('order/print/{id}','OrderController@print')->name('order.print');

    Route::post('/save-token', 'FirebaseController@saveToken')->name('save-token');
    Route::post('/send-notification',  'FirebaseController@sendNotification')->name('send.notification');
    Route::resource('notification','FirebaseController');
    Route::post('notifications/destroy','FirebaseController@destroy')->name('notification.destroys');

    Route::resource('site-settings','SitesettingsController');
    Route::resource('google-analytics','GoogleanalyticsController');
    
    // Menu Route
    Route::resource('menu', 'MenuController');
    Route::post('/menus/destroy', 'MenuController@destroy')->name('menus.destroy');
    Route::post('menues/node', 'MenuController@MenuNodeStore')->name('menus.MenuNodeStore');
    //role routes
    Route::resource('role', 'RoleController');
    Route::post('roles/destroy', 'RoleController@destroy')->name('roles.destroy');
    // Admin Route
    Route::resource('admin', 'AdminController');
    Route::post('/admins/destroy', 'AdminController@destroy')->name('admins.destroy');

    Route::resource('page','PageController');
    Route::resource('blog','BlogController');
    Route::resource('slider','SliderController');
    Route::resource('banner','BannerController');
    Route::resource('special-menu','SpecialmenuController');

    Route::get('/store-settings','SiteController@index');
    Route::post('/theme-data-update/{type}','SiteController@updatethemesettings')->name('themeoption.update');

    Route::get('settings/seo','SeoController@index')->name('seo.index');
    Route::post('seo/{page}','SeoController@update')->name('seo.update');
    Route::get('settings/pwa','SettingsController@pwa')->name('pwa.index');
    Route::post('settings/pwa','SettingsController@pwa_update')->name('pwa.update');
    Route::get('settings/custom_css_js','SettingsController@custom_css_js')->name('custom_css_js.index');
    Route::post('settings/custom_css_js','SettingsController@custom_css_js_update')->name('custom_css_js.update');
    
});



Route::group(['prefix'=>'rider', 'as' => 'rider.', 'namespace' => 'Rider','middleware'=>['InitializeTenancyByDomain','PreventAccessFromCentralDomains','auth','rider','user','tenantenvironment']], function(){
    Route::get('dashboard','DashboardController@dashboard')->name('dashboard');
    Route::get('order','OrderController@index')->name('order.index');
    Route::get('settings','SettingsController@index')->name('settings.index');
    Route::post('settings','SettingsController@update')->name('settings.update');
    Route::get('order/{id}','OrderController@show')->name('order.show');
    Route::post('order/delivered','OrderController@delivered')->name('order.delivered');
    Route::get('order/cancel/{id}','OrderController@cancelled')->name('order.cancelled');
    Route::get('live/orders','DashboardController@live_orders')->name('live.orders');
});





