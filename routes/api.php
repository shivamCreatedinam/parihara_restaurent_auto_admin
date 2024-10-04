<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DriverAuthController;
use App\Http\Controllers\AppHome;
use App\Http\Controllers\CCAvenueController;
use App\Http\Controllers\DeliveryBoyAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/requesting_for_otp', [AuthController::class, 'requesting_for_otp']);
Route::post('/forgot-password', [DriverAuthController::class, 'otpUpdatePassword']);
Route::post('/verify-otp', [AuthController::class, 'register']);
Route::post('/cc-response', [CCAvenueController::class, 'ccResponse'])->name('cc-response');
Route::get('validate-place-order-online', [CCAvenueController::class, 'validate_place_order']);
Route::get('place_order', [CCAvenueController::class, 'place_order']);
Route::post('submitOrderFOrm', [CCAvenueController::class, 'purchaseSubscription'])->name('submitOrderFOrm');

// Route::get('/login', [UserController::class, 'login']);
    Route::group(['middleware' => ['auth:sanctum', 'throttle:500|2200,1']], function () {

        // Route::get('/status', [AppController::class, 'getStatus']);
        // Route::resource('users', UserController::class)->middleware('web');
        Route::get('/logout', [AuthController::class, 'logout']);
        
      

        Route::post('update-user-fcm', [AuthController::class, 'updateFcmToken']);
        Route::post('travel-request', [AuthController::class, 'travelRequest']);
        Route::post('get-trip-driver', [AuthController::class, 'getTripDriver']);
        
        Route::get('my-profile', [AuthController::class, 'get_user']); 
        Route::get('my-wallet', [AuthController::class, 'get_user_wallet']); 
        Route::get('my-wallet-transaction', [AuthController::class, 'getUserWalletRechargeTransaction']); 
        Route::post('update-profile', [AuthController::class, 'update_profile']); 
        Route::post('update-user-profile-image', [AuthController::class, 'update_profile_image']); 
        Route::post('add-address', [AuthController::class, 'add_address']); 
        Route::post('update-address', [AuthController::class, 'update_address']);
        Route::post('address-details', [AuthController::class, 'address_details']);
        Route::post('address-list', [AuthController::class, 'address_list']);
        Route::post('delete-address', [AuthController::class, 'delete_address']);
        Route::post('requesting-for-otp', [AuthController::class, 'requesting_for_otp']);
        Route::post('change-password', [AuthController::class, 'update_password']);
        Route::get('get-location-history', [AuthController::class, 'getLocationSearchHistory']);
        Route::get('user-trip-list', [AuthController::class, 'travelRequestList']);
        Route::post('user-cancel-trip', [AuthController::class, 'cancelTravelRequest']);
        Route::get('user-active-trip', [AuthController::class, 'getCurrentTripUser']);
        
        
        Route::get('homepage', [AppHome::class, 'homepage']);
        Route::get('category-list', [AppHome::class, 'category_list']);
        Route::post('category-product-list', [AppHome::class, 'category_product_list']);
        Route::post('restaurant-product-list', [AppHome::class, 'restaurant_product_list']);
        Route::post('product-details', [AppHome::class, 'product_details']);
        Route::post('add-to-favourite', [AppHome::class, 'add_to_favourite']);
        Route::post('remove-favourite', [AppHome::class, 'remove_favourite']);
        Route::post('my-favourite-list', [AppHome::class, 'my_favourite_list']);
        Route::post('add-to-cart', [AppHome::class, 'add_to_cart']);
        Route::post('remove-from-cart', [AppHome::class, 'remove_from_cart']);
        Route::post('my-cart-list', [AppHome::class, 'my_cart_list']);
        Route::post('cart-update', [AppHome::class, 'cart_update']);
        Route::post('place-order', [AppHome::class, 'place_order']);
        
        Route::post('my-order-list', [AppHome::class, 'my_order_list']);
        Route::post('order-status-list', [AppHome::class, 'order_status_list']);

        
        Route::post('my-order-details', [AppHome::class, 'my_order_details']);
        Route::get('slot-list', [AppHome::class, 'slot_list']);
        Route::get('coupon-list', [AppHome::class, 'coupon_list']);
        Route::post('search-product-list', [AppHome::class, 'search_product_list']);
        Route::get('faq', [AppHome::class, 'faq_list']);
        Route::get('terms-and-condition', [AppHome::class, 'terms_and_condition_list']);
        Route::get('privacy-policy', [AppHome::class, 'privacy_policy_list']);
        Route::get('about-us', [AppHome::class, 'about_us_list']);
        Route::get('contact-us', [AppHome::class, 'contact_us_list']);
        Route::post('check-pincode-for-order', [AppHome::class, 'check_location_list']);

        Route::get('general-permissions', [AppHome::class, 'general_permissions']);

        Route::post('cancel-order', [AppHome::class, 'cancel_order']);
        Route::post('return-order', [AppHome::class, 'return_order']);
        Route::post('apply_promocode', [AppHome::class, 'apply_promocode']);
        Route::post('submit_contact_us_query', [AppHome::class, 'submit_contact_us_query']);
        Route::get('estimated_delivery_days_list', [AppHome::class, 'estimated_delivery_days_list']);
        Route::post('add_ratings', [AppHome::class, 'add_ratings']);
        Route::post('notification-list', [AppHome::class, 'notification_list']);
        Route::get('faqs', [AppHome::class, 'faq_list']);
        Route::get('terms_and_conditions', [AppHome::class, 'terms_and_condition_list']);

    });

 Route::get('getPrice', [AppHome::class, 'set_price']);

Route::post('/update-driver-profile', [DriverAuthController::class, 'updateProfileDrv']);
Route::post('/update-driver-fcm', [DriverAuthController::class, 'updateFcmToken']);
Route::post('/update-driver-lat-long', [DriverAuthController::class, 'updateDriverLatLong']);
Route::post('/driver-signup', [DriverAuthController::class, 'register']);
Route::post('/duty-on-off', [DriverAuthController::class, 'duty_on_off']);
Route::post('/driver-login', [DriverAuthController::class, 'authenticate']);
Route::get('/driver-profile', [DriverAuthController::class, 'get_profile']);
Route::get('/driver-check-active', [DriverAuthController::class, 'getActiveStatus']);
Route::post('/driver-profile-image', [DriverAuthController::class, 'update_profile_image']);
Route::post('/driver-profile-update', [DriverAuthController::class, 'updateDrvProfile']);
Route::post('/driver-vehicle-update', [DriverAuthController::class, 'updateDrvDocument']);
Route::post('/driver-nearest-user', [DriverAuthController::class, 'driverNearestUsers']);
Route::post('/driver-nearest-user-accept-trip', [DriverAuthController::class, 'acceptUserRide']);
Route::post('/driver-verify-trip-otp', [DriverAuthController::class, 'verify_trip_otp']);
Route::post('/driver-notify-user', [DriverAuthController::class, 'notifyUser']);
Route::post('/get-current-trip-details', [DriverAuthController::class, 'getCurrentTrip']);
Route::post('/end-trip', [DriverAuthController::class, 'endTripFunction']);
Route::get('get-package-list', [DriverAuthController::class, 'getpackageList']);
Route::get('driver-trip-list', [DriverAuthController::class, 'travelRequestList']);
Route::get('get-driver-trip-amount', [DriverAuthController::class, 'getTripSuccessAmount']);
Route::get('driver-cancel-trip', [DriverAuthController::class, 'cancelTravelRequestDriv']);
Route::get('driver-active-trip', [DriverAuthController::class, 'getActiveTripDiver']);

// Route::post('/driver-login', [DriverAuthController::class, 'authenticate']);

Route::post('/delivery-boy-login', [DeliveryBoyAuthController::class, 'authenticate']);
Route::post('/delivery-boy-order-list', [DeliveryBoyAuthController::class, 'my_order_list']);

