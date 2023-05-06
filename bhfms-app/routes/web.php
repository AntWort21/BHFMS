<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BoardingController;
use App\Http\Controllers\ComplainController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BoardingImageController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\PaymentController;
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

Route::get('/login', [AuthController::class, 'getLoginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'getRegisterPage'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/', function() {
    return inertia('MainPage');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/welcome', function () {
        return inertia('welcome');
    });

    Route::get('/profile', [UserController::class, 'getProfilePage']);
    Route::post('/profile/update', [UserController::class, 'updateProfile']);

    Route::get('/complain', [ComplainController::class, 'getComplainListPage']);
    Route::get('/complain/create', [ComplainController::class, 'getCreateComplainPage']);
    Route::post('/complain/create', [ComplainController::class, 'createComplain']);
    Route::get('/complain/detail', [ComplainController::class, 'getComplainDetail']);

    Route::post('/complain/status', [ComplainController::class, 'setComplainStatus']);

    Route::get('/complain/owner', [ComplainController::class, 'getOwnerComplainPage']);
    Route::get('/complain/house', [ComplainController::class, 'getSelectedBoardingHouseComplainList']);

    Route::get('/review', [ReviewController::class, 'getAllReviewPage']);
    Route::get('/review/create', [ReviewController::class, 'getCreateReviewOrViewReviewPage']);
    Route::post('/review/create', [ReviewController::class, 'createReview']);
    Route::post('/review/update', [ReviewController::class, 'updateReview']);

    Route::get('/chat', [ChatController::class, 'getChatPage']);
    Route::post('/chat', [ChatController::class, 'storeChatMessage']);

    Route::get('/chat/get', [ChatController::class, 'getChatMessage']);
    Route::get('/wishlist', [WishlistController::class, 'showWishlist']);
    Route::post('/wishlist/add', [WishlistController::class, 'addWishlist']);
    Route::post('/wishlist/remove', [WishlistController::class, 'removeWishlist']);
    Route::post('/boarding/detail/rent/{id}', [BoardingController::class, 'boardingRent']);
    Route::get('/boarding', [BoardingController::class, 'index']);

    //new
    Route::get('/boarding/create', [BoardingController::class, 'create']);



    Route::get('/boardingAdmin', [BoardingController::class, 'indexAdmin']);
    Route::get('/boardingAdmin/request/{id}', [BoardingController::class, 'getAdminApproveBoarding']);
    Route::post('/boardingAdmin/request/{id}', [BoardingController::class, 'AdminApproveBoarding']);
    Route::get('/boardingOwner', [BoardingController::class, 'indexOwner']);
    Route::get('/boarding/create', [BoardingController::class, 'getCreateOwnerBoarding']);
    Route::post('/boarding/create', [BoardingController::class, 'createOwnerBoarding']);
    Route::get('/boarding/update/{id}', [BoardingController::class, 'getUpdateBoarding']);
    Route::get('/boarding/read/{id}', [BoardingController::class, 'getReadBoarding']);
    Route::post('/boarding/update/{id}', [BoardingController::class, 'updateBoarding']);
    Route::get('/boarding/delete/{id}', [BoardingController::class, 'deleteBoarding']);
    Route::get('/boarding/reapprove/{id}', [BoardingController::class, 'getReapproveBoarding']);
    Route::post('/boarding/reapprove/{id}', [BoardingController::class, 'ReapproveBoarding']);

    Route::put('/boarding/image/delete/{id}', [BoardingImageController::class, 'deleteImage']);

    Route::get('/boardingManager', [BoardingController::class, 'indexManager']);
    Route::get('/tenantBoarding', [TenantController::class, 'getAllTenantBoarding']);
    Route::get('/tenantBoarding/read/{id}', [TenantController::class, 'getDetailTenantBoarding']);
    Route::get('/tenantBoarding/request/{id}', [TenantController::class, 'getRequestTenant']);
    Route::post('/tenantBoarding/request/{id}', [TenantController::class, 'RequestTenant']);

    Route::get('/boardingTenant', [BoardingController::class, 'indexTenant']);


    Route::get('/addPaymentManager',[PaymentController::class,'getPaymentPageManager']);

    Route::post('/addPaymentManager',[PaymentController::class,'addPaymentManager']);
    Route::get('/pay',[PaymentController::class,'getPaymentPageTenant']);
    Route::post('/pay',[PaymentController::class,'addPaymentTenant']);
    Route::get('/paymentHistory',[PaymentController::class,'getAllPayment']);
    Route::post('/getInvoiceData',[PaymentController::class,'getInvoiceDetail']);
    Route::get('/cancelPayment',[PaymentController::class,'cancelPayment']);


    Route::get('/facilityAll',[FacilityController::class, 'getAllFacilityPage']);
    Route::get('/facility/create',[FacilityController::class, 'getFacilityCreate']);
    Route::post('/facility/create',[FacilityController::class, 'FacilityCreate']);
    Route::get('/facility/update/{id}',[FacilityController::class, 'getFacilityUpdate']);
    Route::post('/facility/update/{id}',[FacilityController::class, 'FacilityUpdate']);
    Route::get('/facility/read/{id}',[FacilityController::class, 'getFacilityDetail']);
    Route::get('/facility/delete/{id}',[FacilityController::class, 'FacilityDelete']);

    Route::get('/userAll',[UserController::class, 'getAllUserPage']);
    Route::get('/user/update/{id}',[UserController::class, 'getUserUpdate']);
    Route::post('/user/update/{id}',[UserController::class, 'UserUpdate']);
    Route::get('/user/read/{id}',[UserController::class, 'getUserDetail']);
    Route::get('/user/delete/{id}',[UserController::class, 'UserDelete']);
});


Route::get('/boarding/detail', [BoardingController::class, 'getBoardingHouseDetail']);
Route::post('/search', [BoardingController::class, 'searchBoardingByLocation']);
Route::get('/boarding/all', [BoardingController::class, 'getAllBoardingHouse']);


