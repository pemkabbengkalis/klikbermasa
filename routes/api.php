<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::match(['get', 'post'],'login',[App\Http\Controllers\ApiController::class,'login'])->name('login');
Route::match(['get', 'post'],'register',[App\Http\Controllers\ApiController::class,'register'])->name('register');
Route::get('layanan',[App\Http\Controllers\ApiLayananController::class,'index']);
Route::get('layanan/{id?}',[App\Http\Controllers\ApiLayananController::class,'detail']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('store_profil',[App\Http\Controllers\ApiController::class,'store_profil'])->name('store_profil');
});
