<?php

use App\Models\User;
use Illuminate\Support\Facades\Request;
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

Route::get('/', function () {
    return inertia('welcome');
});

Route::get('/login', function() {
    return inertia('Login');
});

Route::get('/register', function() {
    return inertia('Register');
});

Route::post('/users', function() {
    dd(Request::all());
    // User::create($request->validate([
    //     'first_name' => ['required', 'max:50'],
    //     'last'
    // ]));
});
