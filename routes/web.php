<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;

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

Route::get('/', function () {
    return view('welcome');
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
        Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    });

}); //Group Admin end Method 



Route::group(['middleware' => 'vendor'], function(){

    Route::get('/vendor/dashboard',[DashboardController::class,'Dashboard'])->name('vendor.dashboard');

});//Group vendor end Method 



