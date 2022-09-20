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

Route::get('admin', function () {
    return view('admin/login');
})->name('login');
Route::get('/test',[UserController::class,'test']);

Route::post('/verify-admin',[AdminController::class,'verifyAdmin'])->name('verify-admin');

Route::prefix('admin')->group(function () {
    Route::get('/users',[UserController::class,'index'])->name('users-list');
    Route::get('/users/add',function () {
        return view('admin/addUser');
    })->name('add-user');
    Route::post('/user',[UserController::class,'store'])->name('store-user');
    Route::get("edit/{id}", [UserController::class, 'edit'])->name('edit-user');
    Route::get('/user/{id}',[UserController::class,'show'])->name('user-by-id');
    Route::delete('/user/{id}',[UserController::class,'destroy'])->name('delete-user');

    Route::get('/products',[ProductController::class,'index'])->name('products-list');
});
