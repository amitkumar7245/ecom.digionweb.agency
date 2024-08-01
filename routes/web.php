<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;


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

Route::get('/login', function () {
    return view('auth.login');
});




Route::get('/login',[AuthController::class, 'Login'])->name('login');
Route::post('/auth/login',[AuthController::class, 'AuthLogin'])->name('auth.login');
Route::get('/logout',[AuthController::class,'AuthLogout'])->name('auth.logout');


Route::group(['middleware' => 'admin'], function(){

    Route::get('/admin/dashboard',[DashboardController::class,'Dashboard'])->name('admin.dashboard');

}); //Group Admin end Method 



Route::group(['middleware' => 'vendor'], function(){

    Route::get('/vendor/dashboard',[DashboardController::class,'Dashboard'])->name('vendor.dashboard');

});//Group vendor end Method 



