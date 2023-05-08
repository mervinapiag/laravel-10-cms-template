<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Catalog\CatalogController;
use App\Http\Controllers\Promo\PromoController;
use App\Http\Controllers\Index\DashboardController;
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

/** ADMIN LOGIN ROUTES **/
Route::GET('/admin/auth/login', [AuthController::class, 'index'])->name('auth.index');
Route::POST('/admin/auth/login', [AuthController::class, 'loginUser'])->name('auth.login');

/**AUTH ROUTES**/
Route::group(['middleware' => ['auth:sanctum', 'throttle:custom_rate_limiter']], function() {
    Route::group([
        'prefix' => 'admin',
        'as' => 'admin.',
    ], function() {
        /** DASHBOARD ROUTES **/
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        /** USER ROUTES **/
        Route::resource('users', UserController::class);

        /** CATALOG ROUTES **/
        Route::resource('catalogs', CatalogController::class);

        /** PROMO ROUTES **/
        Route::resource('promos', PromoController::class);
    });
});
