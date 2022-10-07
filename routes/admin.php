<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AnalyticsController;

Route::get('/', function () {
return view('admin');
})->name('admin');

Route::Resource('api-users', UserController::class);
Route::Resource('api-products', ProductController::class);
Route::Resource('api-orders', OrderController::class);
Route::post('total-sales', [AnalyticsController::class,'index']);
Route::get('get-categories', [ProductController::class,'getCategories']);
Route::get('send-credentials-mail/{id}',[UserController::class,'sendMail']);
Route::post('/auth',[AdminController::class,'verifyAdmin']);
Route::get('/is-admin-login',[AdminController::class,'isLoggedIn']);
Route::post('/logout',[AdminController::class,'logout']);
Route::get('{url?}', function () {
    return view('admin');
})->where('url', '.*');

