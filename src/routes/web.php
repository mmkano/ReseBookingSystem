<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register');
    Route::get('/thanks', 'showThanksPage')->name('thanks');
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');

Route::controller(ShopController::class)->group(function () {
    Route::get('/', 'index')->name('shop_list');
    Route::post('/', 'index')->name('shop_list');
    Route::post('/favorite/{id}', 'favorite')->name('favorite');
    Route::post('/favorite-ajax/{id}', 'favoriteAjax')->name('favorite.ajax');
    Route::post('/unfavorite/{id}', 'unfavorite')->name('unfavorite');
    Route::post('/unfavorite-ajax/{id}', 'unfavoriteAjax')->name('unfavorite.ajax');
    Route::get('/shop_detail/{id}', 'show')->name('shop_detail');
});

Route::controller(ReservationController::class)->group(function () {
    Route::post('/reserve', 'store')->name('reserve');
    Route::post('/reservation/delete/{id}', 'destroy')->name('reservation.destroy');
});
