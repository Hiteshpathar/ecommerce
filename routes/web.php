<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', function (){
    return view('welcome');
});
Route::get('{url?}', function (Request $request) {
    return view('welcome');
})->where('url', '.*');


//Route::get('/', function () {
//    echo 'test';
//});
//    Route::get('login', function () {
//        return view('admin/login');
//    })->name('admin-login')->withoutMiddleware('validateAdmin');
//
//    Route::post('/verify', [AdminController::class, 'verifyAdmin'])->name('verify-admin')->withoutMiddleware('validateAdmin');
//    Route::get('logout', [AdminController::class, 'logout'])->name('admin-logout');
//    Route::get('editprofile/{email}', [AdminController::class, 'edit'])->name('edit-admin-profile');
//    Route::get('resetpassword', function () {
//        return view('resetPass');
//    })->name('reset-admin-password');
//    Route::post("resetpassword", [AdminController::class, 'resetPassword'])->name('store-updated-admin-password');
//    Route::get('/users', [UserController::class, 'index'])->name('users-list')->middleware('validateAdmin');
//    Route::get('/users/add', function () {
//        return view('admin/addUser');
//    })->name('add-user');
//    Route::post('/user', [UserController::class, 'store'])->name('store-user');
//    Route::get("user/edit/{id}", [UserController::class, 'edit'])->name('edit-user');
//    Route::post('user/update', [UserController::class, 'update'])->name('update-user');
//    Route::get("send-mail/{id}", [UserController::class, 'sendMail'])->name('send-mail');
//    Route::get('user/{id}', [UserController::class, 'show'])->name('user-by-id');
//    Route::delete('user/{id}', [UserController::class, 'destroy'])->name('delete-user');
//    Route::get('user/address/{id}', [UserController::class, 'address'])->name('address-list');
//
//    Route::get('/products', [ProductController::class, 'index'])->name('products-list');
//    Route::get('/product/add', [ProductController::class, 'create'])->name('add-product');
//    Route::post('/product', [ProductController::class, 'store'])->name('store-product');
//    Route::get("product/edit/{id}", [ProductController::class, 'edit'])->name('edit-product');
//    Route::post('/product/update', [ProductController::class, 'update'])->name('update-product');
//    Route::delete('product/{id}', [ProductController::class, 'destroy'])->name('delete-product');
//
//    Route::get('/orders', [OrderController::class, 'index'])->name('orders-list');
//    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//    Route::get('/collections', [ProductController::class, 'collections'])->name('collections-list');
//    Route::get('/test', [UserController::class, 'chartjs']);
//});
