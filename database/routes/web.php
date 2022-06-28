<?php

use Illuminate\Support\Facades\Route;
use App\Events\Notify;
use App\Models\Order;

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

Route::get('chat', [App\Http\Controllers\ChatController::class,'index']);
Route::get('unreadMessageCount', [App\Http\Controllers\HomeController::class,'unreadMessageCount']);

Route::get('email/verification', [App\Http\Controllers\UserController::class,'verification_form'])->name('email.verify');
Route::post('email/verifysend', [App\Http\Controllers\UserController::class,'verifysend'])->name('email.verifysend');

Route::get('logout', [App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');

Route::get('chatroom_users',[App\Http\Controllers\ChatController::class,'getUser'])->name('getUser');

Route::get('regions/{id}/{selectedId?}',[App\Http\Controllers\UserController::class,'getRegions'])->name('getRegions');

Route::get('chatroom_messages/{chatroomid}/{userId}',[App\Http\Controllers\ChatController::class,'chatroomMessages'])->name('chatroom_messages');

Route::post('save_messages',[App\Http\Controllers\ChatController::class,'saveMessages'])->name('save_messages');

Route::get('get_last_messages/{userId}/{chatroomid}',[App\Http\Controllers\ChatController::class,'getSingleMessage']);


Route::group(['middleware' => ['auth']], function () { 
    Route::get('/',[App\Http\Controllers\HomeController::class,'index']);   
});

Route::get('/payout',[App\Http\Controllers\PayoutController::class,'index'])->name('payout');   
Route::post('/payout_request',[App\Http\Controllers\PayoutController::class,'save'])->name('payout.save');   
Route::get('/payout_status_seller/{id}/{status}',[App\Http\Controllers\PayoutController::class,'payoutStatusSeller'])->name('payout.status_seller');
Route::group(['middleware' => ['role:super_admin']], function () { 

    Route::resource('category',App\Http\Controllers\Admin\master\CategoriesConroller::class);
    Route::post('/transactions_store',[App\Http\Controllers\TransactionController::class,'store'])->name('transactions.store');
    Route::get('/check_order_number/{orderNumber}',[App\Http\Controllers\TransactionController::class,'getOrder'])->name('transactions.getOrder');

    Route::post('/importTransction',[App\Http\Controllers\TransactionController::class,'import'])->name('importTransction');

    Route::get('/check_member_id/{memberID}',[App\Http\Controllers\TransactionController::class,'getMenberIdUser'])->name('transactions.member');

    Route::get('/transactions_status/{id}/{status}',[App\Http\Controllers\TransactionController::class,'show'])->name('transactions.show');
    
    Route::get('/payout_status/{id}/{status}',[App\Http\Controllers\PayoutController::class,'payoutStatus'])->name('payout.status');
    Route::post('/payout_reject/',[App\Http\Controllers\PayoutController::class,'payoutReject'])->name('payout.reject');

    Route::get('refund_list/',[App\Http\Controllers\OrdersController::class,'refundList'])->name('refundList');
    Route::get('payment_history/',[App\Http\Controllers\OrdersController::class,'PaymentList'])->name('PaymentList');
   
    Route::get('subcategory/sub-category',[App\Http\Controllers\Admin\master\CategoriesConroller::class,'create_sub'])->name('sub-category');

    Route::get('subcategory',[App\Http\Controllers\Admin\master\CategoriesConroller::class,'subcategory'])->name('subcategory');

    Route::get('subCategoryedit/{id}',[App\Http\Controllers\Admin\master\CategoriesConroller::class,'subCategoryedit'])->name('subCategoryedit');

    Route::get('category/delete/{id}',[App\Http\Controllers\Admin\master\CategoriesConroller::class,'destory'])->name('category.destroy');

    Route::resource('brands',App\Http\Controllers\Admin\master\BrandsController::class);

    Route::get('/brands_delete/{id}',[App\Http\Controllers\Admin\master\BrandsController::class,'destroy'])->name('brands_destory');

    Route::resource('template',App\Http\Controllers\Admin\master\TemplateController::class);

    Route::post('template_store',[App\Http\Controllers\Admin\master\TemplateController::class,'store'])->name('template_store');

    Route::get('template_edit/{id}',[App\Http\Controllers\Admin\master\TemplateController::class,'edit'])->name('template_edit');

    Route::get('template_delete/{id}',[App\Http\Controllers\Admin\master\TemplateController::class,'destroy'])->name('template_delete');

    Route::get('assign-product/{id}',[App\Http\Controllers\Admin\master\TemplateController::class,'assignProducts'])->name('assign_product');

    Route::post('assign-products',[App\Http\Controllers\Admin\master\TemplateController::class,'storeAssignProducts'])->name('store_assign_product');

    Route::post('save-assign-category',[App\Http\Controllers\Admin\master\TemplateController::class,'saveAssignCategory'])->name('save_assign_category');

    Route::get('assign_category/{id}',[App\Http\Controllers\Admin\master\TemplateController::class,'assignCategory'])->name('assign_category');

    Route::get('delete_assign_product/{id}',[App\Http\Controllers\Admin\master\TemplateController::class,'deleteAssignProduct'])->name('delete_assign_product');

    Route::get('/product-status/{id}',[App\Http\Controllers\Admin\buyerseller\ProductController::class,'productStatus'])->name('product_status');
  
    Route::resource('admin_banner',App\Http\Controllers\Admin\BannerController::class);

    Route::get('report/report_abuse/{type?}',[App\Http\Controllers\ReportController::class,'abuseReport'])->name('report_abuse');
    Route::get("feedbacks/{option?}",[App\Http\Controllers\ReportController::class,'feedbacks'])->name('feedbacks');

    Route::get('/seller_list',[App\Http\Controllers\Admin\buyerseller\BuyerSellerController::class,'buyer'])->name('seller_list');

    Route::get('banner',[App\Http\Controllers\BannerController::class,'index'])->name('banner.index');
    Route::get('/transactions',[App\Http\Controllers\TransactionController::class,'index'])->name('transactions');

});
Auth::routes();

Route::get('/product_approve/{id}/{status}/{sort?}',[App\Http\Controllers\Admin\buyerseller\ProductController::class,'productApprove'])->name('product_approve');

Route::post('/updateImageOrder/',[App\Http\Controllers\Admin\buyerseller\ProductController::class,'updateImageOrder'])->name('updateImageOrder');  

// Route::post("register",[App\Http\Controllers\UserController::class,'userRegister']);
Route::get("edit_profile",[App\Http\Controllers\UserController::class,'editProfile'])->name('edit_profile');

Route::get("edit_profile",[App\Http\Controllers\UserController::class,'editProfile'])->name('edit_profile');

Route::post("updateProfile",[App\Http\Controllers\UserController::class,'updateProfile'])->name('updateProfile');


Route::get("feedbackAndSupport",[App\Http\Controllers\ReportController::class,'feedbackAndSupport'])->name('feedbackAndSupport');

Route::post("save_feedback",[App\Http\Controllers\ReportController::class,'saveFeedback'])->name('saveFeedback');

Route::get("get_reviews/{id}",[App\Http\Controllers\Admin\buyerseller\ProductController::class,'getReviews'])->name('getReviews');

Route::get("notifications/",[App\Http\Controllers\UserController::class,'getNotification'])->name('getNotification');

Route::get("add_bank_details/",[App\Http\Controllers\UserController::class,'addBankDetails'])->name('addBankDetails');
Route::post("addBankDetailsUpdate/",[App\Http\Controllers\UserController::class,'addBankDetailsUpdate'])->name('addBankDetailsUpdate');

Route::get("notifications_list/",[App\Http\Controllers\UserController::class,'listNotification'])->name('listNotification');

Route::get("notifications_reat/{id}",[App\Http\Controllers\UserController::class,'readNotification'])->name('readNotification');

Route::get("verify/{token}",[App\Http\Controllers\VerifyController::class,'verifyUser']);
 Route::get('gatSubCategory/{id}/{selected?}',[App\Http\Controllers\Admin\master\CategoriesConroller::class,'gatSubCategory']);
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/refresh_captcha', [App\Http\Controllers\VerifyController::class, 'refreshCaptcha']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/testMy', [App\Http\Controllers\HomeController::class, 'test'])->name('test');

Route::resource('products',App\Http\Controllers\Admin\buyerseller\ProductController::class);
Route::post('products_edit/{id}',[App\Http\Controllers\Admin\buyerseller\ProductController::class,'update'])->name('products.update');

Route::get('delete_image/{id}/{productId}',[App\Http\Controllers\Admin\buyerseller\ProductController::class,'deleteImage'])->name('delete_image');

Route::post('banner/store',[App\Http\Controllers\BannerController::class,'store'])->name('banner.store');
Route::get('banner/create',[App\Http\Controllers\BannerController::class,'create'])->name('banner.create');

Route::post('bulk_delete/',[App\Http\Controllers\Admin\buyerseller\ProductController::class,'destroy']);

Route::get('/extendDate/{id}',[App\Http\Controllers\Admin\buyerseller\ProductController::class,'extendDate']);

Route::get('/product_destroy/{id}',[App\Http\Controllers\Admin\buyerseller\ProductController::class,'productDestroy'])->name('product_destroy');

Route::get('/buyerseller/',[App\Http\Controllers\Admin\buyerseller\BuyerSellerController::class,'index']);
Route::resource('/buyerseller',App\Http\Controllers\Admin\buyerseller\BuyerSellerController::class);

Route::get('/buyerseller_approve/{id}/{type}',[App\Http\Controllers\Admin\buyerseller\BuyerSellerController::class,'buyersellerAprove'])->name('buyerseller_approve');

Route::get('/buyerseller_destroy/{id}',[App\Http\Controllers\Admin\buyerseller\BuyerSellerController::class,'buyerseller_destroy'])->name('buyerseller_destroy');
Route::get('/orders/{number?}',[App\Http\Controllers\OrdersController::class,'getOrder'])->name('orders');
Route::get('/orders/show/{id}',[App\Http\Controllers\OrdersController::class,'show'])->name('orders_show');


Route::get('/notification_order_details/{id}',[App\Http\Controllers\OrdersController::class,'notificationOrderDetails'])->name('notification_order_details');

Route::post('/orders_status/',[App\Http\Controllers\OrdersController::class,'changeState'])->name('orders_status');
Route::post('/noti_orders_status/',[App\Http\Controllers\OrdersController::class,'NotichangeState'])->name('orders_status');

// Route::get('/bid_list/{search?}',[App\Http\Controllers\OrdersController::class,'bidList'])->name('bid_list');

Route::get('/chat-with-user',[App\Http\Controllers\Admin\chatwithUser\ChatWithUserController::class,'chatWithUser'])->name('chat_with_user');

Route::post('/user_messages',[App\Http\Controllers\Admin\chatwithUser\ChatWithUserController::class,'userMessages'])->name('user_messages');

Route::get('/testmail',function(){
    return view('mail.verify_mail');
});