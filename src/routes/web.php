<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminAuthController;

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
    Route::get('/verify', 'verify')->name('verify');
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
Route::middleware(['auth'])->group(function () {
    Route::post('/shop_detail/{id}/review', [ShopController::class, 'addReview'])->name('shop.addReview');
});

Route::controller(ReservationController::class)->group(function () {
    Route::post('/reserve', 'store')->name('reserve');
    Route::post('/reservation/delete/{id}', 'destroy')->name('reservation.destroy');
    Route::get('/done', 'showDonePage')->name('done');
    Route::get('/reservation/edit/{id}', 'edit')->name('reservation.edit');
    Route::put('/reservation/update/{id}', 'update')->name('reservation.update');
    Route::get('/reservation/edit_done', 'showEditDonePage')->name('reservation.edit_done');
});

Route::controller(ReviewController::class)->group(function () {
    Route::post('/review', 'store')->name('review.store');
    Route::get('/shop/{id}', 'show')->name('shop.show');
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/owners/create', [AdminAuthController::class, 'showCreateOwnerForm'])->name('admin.owners.create');
        Route::post('/owners', [AdminAuthController::class, 'storeOwner'])->name('admin.owners.store');
        Route::get('/owners/done', [AdminAuthController::class, 'showOwnerCreationDonePage'])->name('admin.owners.done');
    });
});

