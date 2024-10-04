<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\TermsAndConditionController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\DeliveryChargeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\EarningController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\ContactQueryController;
use App\Http\Controllers\EstimatedDeliveryController;
use App\Http\Controllers\TravelRequestController;
use App\Http\Controllers\RestaurantController;

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

Route::get('/', function () {
    return view('welcome');
});
// $date  = date('Y-m-d');
// if($date < date('Y-m-d',strtotime('2023-01-10'))){
    Route::prefix('sysadmin')->group(function () {
        Route::get('/', [AdminController::class, 'index']);
        Route::post('/auth',[AdminController::class,'auth'])->name('admin.auth');
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
    
        Route::get('/change-password', [AdminController::class, 'create']);
        Route::get('/my-profile', [AdminController::class, 'my_profile']);
        Route::get('/set-price', [AdminController::class, 'setPrice']);
        Route::post('/update_price', [AdminController::class, 'update_price'])->name('update_price');
        Route::post('/update-profile', [AdminController::class, 'edit'])->name('update_profile');
        Route::post('/change-password', [AdminController::class, 'change_password'])->name('change_password');
    
    
    
        Route::get('/slider-list', [SliderController::class, 'index']);
        Route::get('/add-slider', [SliderController::class, 'create']);
        Route::post('/add-slider', [SliderController::class, 'store'])->name('add.slider');
        Route::get('/edit-slider/{id}', [SliderController::class, 'show']);
        Route::post('/edit-slider', [SliderController::class, 'edit'])->name('edit.slider');
        Route::get('/delete-slider/{id}', [SliderController::class, 'destroy']);
    
    
       
        Route::get('/add-banner', [SliderController::class, 'banner_create']);
        Route::post('/add-banner', [SliderController::class, 'store'])->name('add.banner');
        Route::get('/edit-banner/{id}', [SliderController::class, 'banner_show']);
        Route::post('/edit-banner', [SliderController::class, 'edit'])->name('edit.banner');
        Route::get('/delete-banner/{id}', [SliderController::class, 'destroy']);
        Route::get('/delete-banner/{id}', [SliderController::class, 'banner_destroy']);
    
    
        Route::get('/category-list', [CategoryController::class, 'index']);
        Route::get('/add-category', [CategoryController::class, 'create']);
        Route::post('/add-category', [CategoryController::class, 'store'])->name('add.category');
        Route::get('/edit-category/{id}', [CategoryController::class, 'show']);
        Route::post('/edit-category', [CategoryController::class, 'edit'])->name('edit.category');
        Route::get('/delete-category/{id}', [CategoryController::class, 'destroy']);
       
       
        Route::get('/trip-list', [TravelRequestController::class, 'index']);
        // Route::get('/add-category', [CategoryController::class, 'create']);
        // Route::post('/add-category', [CategoryController::class, 'store'])->name('add.category');
        Route::get('/trip-details/{id}', [TravelRequestController::class, 'edit']);
        // Route::post('/edit-category', [CategoryController::class, 'edit'])->name('edit.category');
        // Route::get('/delete-category/{id}', [CategoryController::class, 'destroy']);
    
        Route::get('/user-list', [UserController::class, 'index']);
          Route::get('/user-status/{sts}/{id}', [UserController::class, 'update_status']);
        Route::get('/add-user', [UserController::class, 'create']);
        Route::post('/add-user', [UserController::class, 'store'])->name('add.user');
        Route::get('/edit-user/{id}', [UserController::class, 'show']);
        // Route::post('/edit-category', [UserController::class, 'edit'])->name('edit.category');
        // Route::get('/delete-category/{id}', [UserController::class, 'destroy']);
        Route::get('/export-users',[UserController::class,
                'exportUsers'])->name('export-users');
                
        Route::get('/drivers-list', [DriverController::class, 'index']);
        Route::get('/driver-status/{sts}/{id}', [DriverController::class, 'update_status']);
        Route::get('/add-user', [UserController::class, 'create']);
        Route::post('/add-user', [UserController::class, 'store'])->name('add.user');
        Route::get('/edit-driver/{id}', [DriverController::class, 'show']);
        Route::get('/export-users',[UserController::class,
                'exportUsers'])->name('export-users');
    
        Route::get('/restaurant-list', [RestaurantController::class, 'index']);
        Route::get('/add-restaurant', [RestaurantController::class, 'create']);
        Route::post('/add-restaurant', [RestaurantController::class, 'store'])->name('admin.restaurant');
        Route::get('/edit-restaurant/{id}', [RestaurantController::class, 'show']);
        Route::get('/restaurant-status/{status}/{id}', [RestaurantController::class, 'update_status']);
        Route::post('/edit-restaurant', [RestaurantController::class, 'update'])->name('admin.update_restaurant');
        
    
    
        Route::get('/sub-admin-list', [UserController::class, 'sub_admin_index']);
        Route::get('/add-sub-admin', [UserController::class, 'sub_admin_create']);
        Route::post('/add-sub-admin', [UserController::class, 'store'])->name('add.sub_admin');
        Route::get('/edit-sub-admin/{id}', [UserController::class, 'sub_admin_show']);
        // Route::post('/edit-category', [UserController::class, 'edit'])->name('edit.category');
        // Route::get('/delete-category/{id}', [UserController::class, 'destroy']);
        Route::get('/export-users',[UserController::class,
                'exportUsers'])->name('export-users');
    
               
    
        Route::get('/faq', [FaqController::class, 'index']);
        Route::get('/add-faq', [FaqController::class, 'create']);
        Route::post('/add-faq', [FaqController::class, 'store'])->name('add.faq');
        Route::get('/edit-faq/{id}', [FaqController::class, 'show']);
        Route::post('/edit-faq', [FaqController::class, 'edit'])->name('edit.faq');
        Route::get('/delete-faq/{id}', [FaqController::class, 'destroy']);
    
        Route::get('/privacy-policy', [PrivacyPolicyController::class, 'index']);
        Route::get('/edit-privacy-policy/{id}', [PrivacyPolicyController::class, 'show']);
        Route::post('/edit-privacy-policy', [PrivacyPolicyController::class, 'edit'])->name('edit.privacy_policy');
        
        Route::get('/terms-and-conditions', [TermsAndConditionController::class, 'index']);
        Route::get('/edit-terms-and-conditions/{id}', [TermsAndConditionController::class, 'show']);
        Route::post('/edit-terms-and-conditions', [TermsAndConditionController::class, 'edit'])->name('edit.t_a_c');
        
    
        Route::get('/about-us', [AboutUsController::class, 'index']);
        Route::get('/edit-about-us/{id}', [AboutUsController::class, 'show']);
        Route::post('/edit-about-us', [AboutUsController::class, 'edit'])->name('edit.about_us');
    
        Route::get('/contact-us', [ContactUsController::class, 'index']);
        Route::get('/edit-contact-us/{id}', [ContactUsController::class, 'show']);
        Route::post('/edit-contact-us', [ContactUsController::class, 'edit'])->name('edit.contact_us');
        
        
    
        Route::get('/notification', [NotificationController::class, 'index']);
        Route::get('/add-notification', [NotificationController::class, 'create']);
        Route::post('/add-notification', [NotificationController::class, 'store'])->name('add.notification');
        Route::get('/edit-notification/{id}', [NotificationController::class, 'show']);
        Route::post('/edit-notification', [NotificationController::class, 'edit'])->name('edit.notification');
        Route::get('/delete-notification/{id}', [NotificationController::class, 'destroy']);
        
    
        Route::get('/delivery-charge', [DeliveryChargeController::class, 'index']);
        Route::get('/add-delivery-charge', [DeliveryChargeController::class, 'create']);
        Route::post('/add-delivery-charge', [DeliveryChargeController::class, 'store'])->name('add.delivery_charge');
        Route::get('/edit-delivery-charge/{id}', [DeliveryChargeController::class, 'show']);
        Route::post('/edit-delivery-charge', [DeliveryChargeController::class, 'edit'])->name('edit.delivery_charge');
         Route::get('/delete-delivery-charge/{id}', [DeliveryChargeController::class, 'destroy']);
        
       
    
        Route::get('/offers', [OfferController::class, 'index']);
        Route::get('/add-offer', [OfferController::class, 'create']);
        Route::post('/add-offer', [OfferController::class, 'store'])->name('add.offer');
        Route::get('/edit-offer/{id}', [OfferController::class, 'show']);
        Route::post('/edit-offer', [OfferController::class, 'edit'])->name('edit.offer');
        Route::get('/delete-offer/{id}', [OfferController::class, 'destroy']);
        Route::post('offer_get_product', [OfferController::class, 'get_product']);
    
    
        Route::get('/coupons', [CouponController::class, 'index']);
        Route::get('/add-coupon', [CouponController::class, 'create']);
        Route::post('/add-coupon', [CouponController::class, 'store'])->name('add.coupon');
        Route::get('/edit-coupon/{id}', [CouponController::class, 'show']);
        Route::post('/edit-coupon', [CouponController::class, 'edit'])->name('edit.coupon');
        Route::get('/delete-coupon/{id}', [CouponController::class, 'destroy']);
    
        Route::get('/orders', [RestaurantController::class, 'order_index']);
        Route::get('/return-orders', [OrderController::class, 'return_orders']);
        Route::get('/view-order-details/{id}', [RestaurantController::class, 'order_show']);
        Route::post('/update-status', [OrderController::class, 'update_order_status'])->name('update.order_status');
    
    
        Route::get('/earning', [EarningController::class, 'index']);
        Route::get('/exporter', [EarningController::class, 'exportEr']);
    
        Route::get('/report', [EarningController::class, 'report']);
     

    
        Route::get('/ratings', [RatingController::class, 'index']);
    
        Route::get('/query', [ContactQueryController::class, 'index']);
        
        
        
    
            Route::get('/logout', function () {
            session()->forget('ADMIN_LOGIN');
            session()->forget('ADMIN_ID');
            session()->forget('ADMIN');
            session()->forget('ADMINEMAIL');
            session()->flash('error','Logout successfully');
            return redirect('sysadmin');
            });
    });
    
    
Route::get('cmd', function () {

    \Artisan::call('make:controller DeliveryBoyAuthController ');

    dd("Cache is cleared");

});

Route::get('make', function () {

    \Artisan::call('migrate --path=/database/migrations/2024_02_24_065746_create_delivery_boys_table.php');

    dd("Cache is cleared");

});

Route::get('exp', function () {

    \Artisan::call('make:export ExportErning --model=Order');

    dd("Cache is cleared");

});
// }
