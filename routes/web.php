<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\DataPengajuanLayananController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/',function(){
return  to_route('login');
});
Route::controller(LoginController::class)->group(function ()  {
    Route::get('login', 'loginForm')->name('login');
    Route::get( 'captcha.jpg', 'generateCaptcha')->name('captcha');
    Route::post( 'login', 'loginSubmit')->name('login.submit');
    Route::match(['post', 'get'], 'logout',  'logout')->name('logout');
});

Route::match(['post','get'],'media/destroy', [FileManagerController::class, 'destroy'])->name('media.destroy');
Route::match(['post','get'], 'media/upload', [FileManagerController::class, 'upload'])->name('media.upload');
Route::match(['post', 'get'], 'media/{slug}', [FileManagerController::class, 'stream_by_id'])
    ->where('slug', '(?!' . implode('|', ['destroy', 'upload']) . ')[a-zA-Z0-9-]+(\.('.implode('|', flc_ext()).'))$')->name('stream');

Route::prefix('v1')->middleware(['auth','panel'])->group(function () {
 Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
 Route::get('setting',[DashboardController::class,'setting'])->name('setting');
 Route::resource('user',UserController::class)->except('create');
 Route::resource('instansi',InstansiController::class);
 Route::resource('layanan',LayananController::class);
 Route::resource('banner',BannerController::class);
 Route::resource('pengajuan',DataPengajuanLayananController::class);
 Route::resource('kategori',KategoriController::class);
});
