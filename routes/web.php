<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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


Route::group(['prefix'=>'admin','middleware'=>'validateAdmin'],function () {
    Route::get('/',function (){
        return redirect()->route('users-list');
    });
    Route::get('login', function () {
        return view('admin/login');
    })->name('admin-login')->withoutMiddleware('validateAdmin');

    Route::post('/verify',[AdminController::class,'verifyAdmin'])->name('verify-admin')->withoutMiddleware('validateAdmin');
    Route::get('logout', [AdminController::class, 'logout'])->name('admin-logout');
    Route::get('editprofile/{email}', [AdminController::class, 'edit'])->name('edit-admin-profile');
    Route::get('resetpassword', function () {
        return view('resetPass');
    })->name('reset-admin-password');
    Route::post("resetpassword", [AdminController::class, 'resetPassword'])->name('store-updated-admin-password');
    Route::get('/users',[UserController::class,'index'])->name('users-list')->middleware('validateAdmin');
    Route::get('/users/add',function () {
        return view('admin/addUser');
    })->name('add-user');
    Route::post('/user',[UserController::class,'store'])->name('store-user');
    Route::get("edit/{id}", [UserController::class, 'edit'])->name('edit-user');
    Route::post('/user/update', [UserController::class, 'update'])->name('update-user');
    Route::get("send-mail/{id}", [UserController::class, 'sendMail'])->name('send-mail');
    Route::get('/user/{id}',[UserController::class,'show'])->name('user-by-id');
    Route::delete('/user/{id}',[UserController::class,'destroy'])->name('delete-user');
    Route::get('approve/{id}/{is_approved}', [UserController::class, 'approve'])->name('approve-user');

    Route::get('/products',[ProductController::class,'index'])->name('products-list');
});
