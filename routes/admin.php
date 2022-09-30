<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', function () {
return view('admin');
})->name('admin');

Route::Resource('api-users', UserController::class);
Route::get('send-credentials-mail/{id}',[UserController::class,'sendMail']);
Route::get('{url?}', function () {
    return view('admin');
})->where('url', '.*');

