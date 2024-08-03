<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/userlogin', function () {
    return view('frontend.userauth.login');
});
Route::get('/userregistration', function () {
    return view('frontend.userauth.registration');
});

Route::get('/forgot-password', function () {
    return view('frontend.userauth.forgot_password');
});

Route::get('/', function () {
    return view('frontend.index');
});


Route::get('/login',[AuthController::class, 'Login'])->name('login');
Route::post('/auth/login',[AuthController::class, 'AuthLogin'])->name('auth.login');
Route::get('/logout',[AuthController::class,'AuthLogout'])->name('auth.logout');
Route::get('/auth/forgot',[AuthController::class,'AuthForgot'])->name('auth.forgot');
Route::post('/store/forgot',[AuthController::class,'StoreForgot'])->name('store.forgot');
Route::get('/reset/{token}',[AuthController::class,'Reset'])->name('reset');
Route::post('reset/{token}',[AuthController::class,'PostReset'])->name('reset');


Route::group(['middleware' => 'admin'], function(){

    Route::get('/admin/dashboard',[DashboardController::class,'Dashboard'])->name('admin.dashboard');

    Route::controller(AdminController::class)->group(function(){
        Route::get('/admin/profile', 'AdminProfile')->name('admin.profile');
        Route::post('/admin/profile/store', 'AdminProfileStore')->name('admin.profile.store');
    });

}); //Group Admin end Method 



Route::group(['middleware' => 'vendor'], function(){

    Route::get('/vendor/dashboard',[DashboardController::class,'Dashboard'])->name('vendor.dashboard');

    Route::controller(VendorController::class)->group(function(){
        Route::get('/vendor/profile', 'VendorProfile')->name('vendor.profile');
        Route::post('/vendor/profile/store', 'VendorProfileStore')->name('vendor.profile.store');
    });

});//Group vendor end Method 



