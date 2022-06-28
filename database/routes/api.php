<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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


// Route::group(['middleware' => 'auth:sanctum'], function(){
//     //All secure URL's

// });

Route::post("login",[App\Http\Controllers\UserController::class,'userLogin']);
Route::post("login_with_social",[App\Http\Controllers\UserController::class,'loginWithSocial']);
Route::post("register",[App\Http\Controllers\UserController::class,'userRegister']);
Route::get("logout",[App\Http\Controllers\UserController::class,'logout']);

Route::post("verifylinksend",[App\Http\Controllers\UserController::class,'verifylinksend']);

Route::post("all_products/",[App\Http\Controllers\ProductsController::class,'allProducts'])->name('all_products');

Route::post("saveReport/",[App\Http\Controllers\API\MyProfileController::class,'saveReport'])->name('saveReport');
Route::post("makePayment/",[App\Http\Controllers\API\MyProfileController::class,'makePayment'])->name('makePayment');

Route::get("get_filter_product/{product}",[App\Http\Controllers\ProductsController::class,'getFilterProduct']);

Route::post("search_products/",[App\Http\Controllers\ProductsController::class,'searchProducts']);
Route::post("sort_products/",[App\Http\Controllers\ProductsController::class,'sortProducts']);

Route::get("product_details/{id}",[App\Http\Controllers\ProductsController::class,'productDetails'])->name('product_details');

Route::get("product_other_info/{type}",[App\Http\Controllers\ProductsController::class,'productOtherInfo'])->name('product_details');

Route::get("get_all_categories/{limit?}",[App\Http\Controllers\API\ItemsAndCategoriesController::class,'getAllCategories']);

Route::get("get_categories",[App\Http\Controllers\API\ItemsAndCategoriesController::class,'getCategories']);

Route::post("smiler_product",[App\Http\Controllers\ProductsController::class,'similerProduct']);

Route::get("get_items_by_category/{id}",[App\Http\Controllers\API\ItemsAndCategoriesController::class,'getItemsByCategory']);

Route::get("getSingleProductReview/{id}",[App\Http\Controllers\API\TemplateController::class,'getSingleProductReview'])->name('getSingleProductReview');

Route::get("get_template_products/{template}",[App\Http\Controllers\API\TemplateController::class,'getTemplateProduct'])->name('get_template_products');

Route::get("get_template/",[App\Http\Controllers\API\TemplateController::class,'getTemplate'])->name('get_template');

// Route::get("get_template",[App\Http\Controllers\API\TemplateController::class,'test'])->name('get_template');

   Route::get("get_bid_history/{proId}",[App\Http\Controllers\API\PlaceBidController::class,'getBidHistory']);

    Route::post("productReview/",[App\Http\Controllers\API\MyProfileController::class,'productReview']);

Route::group(['middleware' => 'auth:api'], function(){

    Route::get("get_user_info/",[UserController::class,'getUserInfo'])->name('get_user_info');

    Route::get("order_details/{orderId}",[App\Http\Controllers\OrdersController::class,'orderDetails']);

    Route::post("profile_update/",[UserController::class,'profileUpdate'])->name('profileUpdate');

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::post("cart_data",[App\Http\Controllers\CartsController::class,'cartDataStore']);

    Route::get("get_cart_data/",[App\Http\Controllers\CartsController::class,'getCartData'])->name('get_cart_data');
    Route::get("is_cart_empty/",[App\Http\Controllers\CartsController::class,'isCartEmpty'])->name('isCartEmpty');

    Route::post("update_cart_item/",[App\Http\Controllers\CartsController::class,'updateCartItem'])->name('update_cart_item');

    Route::get("delete_cart_item/{id?}",[App\Http\Controllers\CartsController::class,'deleteCart'])->name('deleteCart');

    Route::post("post_order",[App\Http\Controllers\OrdersController::class,'postOrder']);
    Route::post("getOrderByNumber",[App\Http\Controllers\API\OrdersApiController::class,'getOrderByNumber']);
    
    Route::post("cancelOrder",[App\Http\Controllers\API\OrdersApiController::class,'cancelOrder']);

    Route::post("createOrder",[App\Http\Controllers\API\OrdersApiController::class,'createOrder']);
 
    Route::post("shipping_address",[App\Http\Controllers\API\OrdersApiController::class,'storeShippingAddress']);
 
    Route::get("get_shipping_address",[App\Http\Controllers\API\OrdersApiController::class,'getShippingAddress']);
 
    Route::get("get_order_details/{id}",[App\Http\Controllers\API\OrdersApiController::class,'getOrderDetails']);

    Route::get("get_orders/",[App\Http\Controllers\API\OrdersApiController::class,'getOrders']);

    Route::post("place_bid",[App\Http\Controllers\API\PlaceBidController::class,'placeBid']);

    Route::post("add_wishlist",[App\Http\Controllers\API\WishListController::class,'addWishList']);
    Route::get("get_wishlist",[App\Http\Controllers\API\WishListController::class,'getWishList']);
    Route::get("delete_wishlist_item/{id?}",[App\Http\Controllers\API\WishListController::class,'deleteWishlistItem']);

    Route::get("delete_address/{id}",[App\Http\Controllers\API\MyProfileController::class,'deleteAddress']);

    Route::get("verify/{token}",[App\Http\Controllers\VerifyController::class,'verifyUser']);
    
    Route::post("sellerReview/",[App\Http\Controllers\API\MyProfileController::class,'sellerReview']);

    Route::get("get_user/",[App\Http\Controllers\API\ChatController::class,'getUser']);
    
    Route::get("totalReadMessage/",[App\Http\Controllers\API\ChatController::class,'totalReadMessage']);
    
    Route::get("get_messages/{chatroomId}/{userId}/{senderId?}",[App\Http\Controllers\API\ChatController::class,'getMessages']);

    Route::get("start_chat/{sellerId}",[App\Http\Controllers\API\ChatController::class,'startChat']);

});