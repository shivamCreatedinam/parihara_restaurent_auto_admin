<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DeliveryBoyController;

use App\Http\Controllers\RestaurantAuthController;

/*
|--------------------------------------------------------------------------
| restaurant Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// $date  = date('Y-m-d');
// if($date < date('Y-m-d',strtotime('2023-01-10'))){
    
        Route::get('/login', [RestaurantAuthController::class, 'index']);
        Route::post('/auth',[RestaurantAuthController::class,'auth'])->name('restaurant.auth');
        Route::get('/dashboard', [RestaurantAuthController::class, 'dashboard']);
        Route::get('/change-password', [RestaurantAuthController::class, 'create']);
        Route::get('/my-profile', [RestaurantAuthController::class, 'my_profile']);
        Route::post('/update-profile', [RestaurantAuthController::class, 'edit'])->name('restaurant.update_profile');
        Route::post('/change-password', [RestaurantAuthController::class, 'change_password'])->name('change_password');
    
    
        
       
        Route::get('/delivery-boy-list', [DeliveryBoyController::class, 'index']);
        Route::get('/add-delivery-boy', [DeliveryBoyController::class, 'create']);
        Route::post('/add-delivery-boy', [DeliveryBoyController::class, 'store'])->name('add.delivery.boy');
        Route::get('/edit-delivery-boy/{id}', [DeliveryBoyController::class, 'edit']);
        Route::post('/edit-delivery-boy', [DeliveryBoyController::class, 'update'])->name('edit.delivery.boy');
        Route::get('/delete-delivery-boy/{id}', [DeliveryBoyController::class, 'destroy']);
      
        
     
        Route::get('/attributes', [ProductAttributeController::class, 'index']);
        Route::get('/add-product-attributes', [ProductAttributeController::class, 'create']);
        Route::post('/add-product-attributes', [ProductAttributeController::class, 'store'])->name('add.attributes');
        Route::get('/edit-product-attributes/{id}', [ProductAttributeController::class, 'show']);
        Route::post('/edit-product-attributes', [ProductAttributeController::class, 'edit'])->name('edit.attributes');
        Route::get('/delete-product-attributes/{id}', [ProductAttributeController::class, 'destroy']);
        
        Route::get('/product-list', [ProductController::class, 'index']);
        Route::get('/add-product', [ProductController::class, 'create']);
        Route::post('/add-product', [ProductController::class, 'store'])->name('res.add.product');
        Route::get('/edit-product/{id}', [ProductController::class, 'show']);
        Route::post('/edit-product', [ProductController::class, 'edit'])->name('edit.product');
        Route::get('/delete-product/{id}', [ProductController::class, 'destroy']);
        
        Route::get('/deals-week/{sts}/{id}', [ProductController::class, 'deals_week']);
        Route::get('/product-popular/{sts}/{id}', [ProductController::class, 'product_popular']);
        
    

    
        Route::get('/location', [LocationController::class, 'index']);
        Route::get('/add-location', [LocationController::class, 'create']);
        Route::post('/add-location', [LocationController::class, 'store'])->name('add.location');
        Route::get('/edit-location/{id}', [LocationController::class, 'show']);
        Route::post('/edit-location', [LocationController::class, 'edit'])->name('edit.location');
        Route::get('/delete-location/{id}', [LocationController::class, 'destroy']);
        Route::post('/get_city', [LocationController::class, 'get_city']);
    
    
    
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/return-orders', [OrderController::class, 'return_orders']);
        Route::get('/view-order-details/{id}', [OrderController::class, 'show']);
        Route::post('/update-status', [OrderController::class, 'update_order_status'])->name('update.restaurant.order_status');
        
    
        
        
    
        Route::get('/logout', function () {
            session()->forget('REST_LOGIN');
            session()->forget('REST_ID');
            session()->forget('REST');
            session()->forget('RESTEMAIL');
            session()->flash('error','Logout successfully');
            return redirect('restaurant/login');
            });
    
    
    
Route::get('cmd', function () {

    \Artisan::call('route:clear');

    dd("Cache is cleared");

});

Route::get('make', function () {

    \Artisan::call('migrate --path=/database/migrations/2024_02_23_153700_create_restaurants_table.php');

    dd("Cache is cleared");

});

Route::get('exp', function () {

    \Artisan::call('make:export ExportErning --model=Order');

    dd("Cache is cleared");

});
// }
