<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BoardingController;
use App\Http\Controllers\BoardingImageController;
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
});

Route::get('/boardingAdmin', [BoardingController::class, 'indexAdmin']);
Route::get('/boardingOwner', [BoardingController::class, 'indexOwner']);


Route::get('/boarding/create', [BoardingController::class, 'getCreateOwnerBoarding']);
Route::post('/boarding/create', [BoardingController::class, 'createOwnerBoarding']);
Route::get('/boarding/update/{id}', [BoardingController::class, 'getUpdateBoarding']);
Route::get('/boarding/read/{id}', [BoardingController::class, 'getReadBoarding']);
Route::post('/boarding/update/{id}', [BoardingController::class, 'updateBoarding']);
Route::get('/boarding/delete/{id}', [BoardingController::class, 'deleteBoarding']);

Route::put('/boarding/image/delete/{id}', [BoardingImageController::class, 'deleteImage']);

Route::get('/boardingManager', [BoardingController::class, 'indexManager']);

Route::get('/boarding/test', [BoardingController::class, 'testCarousel']);
Route::get('/boarding/all', [BoardingController::class, 'getAllBoardingHouse']);
