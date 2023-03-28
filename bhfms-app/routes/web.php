<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BoardingController;
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

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/', function () {
        return inertia('welcome');
    });

    Route::get('/profile', [UserController::class, 'getProfilePage']);

    Route::post('/profile/update', [UserController::class, 'updateProfile']);
});

Route::resource('boarding', BoardingController::class);
