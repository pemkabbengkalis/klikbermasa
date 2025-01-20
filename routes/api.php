<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::match(['get', 'post'],'login',[App\Http\Controllers\ApiController::class,'login']);
Route::match(['get', 'post'],'register',[App\Http\Controllers\ApiController::class,'register']);
Route::get('layanan',[App\Http\Controllers\ApiLayananController::class,'index']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('store_profil',[App\Http\Controllers\ApiController::class,'store_profil'])->name('store_profil');
});
