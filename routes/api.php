<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/v1')->group(function() {

    Route::prefix('/admin')->group(function() {
        Route::controller(AdminController::class)->group(function () {
            Route::post('/create',  'register');
            Route::post('/login', 'login');
            Route::get('/logout', 'logout')->middleware('auth:api,admin');
            Route::get('/user-listing', 'listUsers')->middleware('admin');
            Route::put('/user-edit/{uuid}', 'editUser')->middleware('admin');
            Route::delete('/user-delete/{uuid}', 'deleteUser')->middleware('admin');
        });
    });

    Route::prefix('/user')->group(function() {
        Route::controller(UserController::class)->group(function () {
            Route::post('/login', 'login');
            Route::post('/create', 'register');
            Route::get('/logout', 'logout')->middleware('auth:api');
            Route::get('/orders', 'getOrders');
            Route::put('/edit', 'update');
            Route::delete('/delete','destroy');
        });
        Route::post('/reset-password-token', [ResetPasswordController::class, 'reset']);
        Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    });

    Route::controller(BrandController::class)->group(function () {
        Route::get('/brands', 'index');
        Route::prefix('/brand')->group(function () {
            Route::post('/create', 'store');
            Route::get('/{uuid}', 'show');
            Route::put('/{uuid}', 'update');
            Route::delete('/{uuid}', 'destroy');
        });
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'index');
        Route::prefix('/category')->group(function () {
            Route::post('/create', 'store');
            Route::get('/{uuid}', 'show');
            Route::put('/{uuid}', 'update');
            Route::delete('/{uuid}', 'destroy');
        });
    });

    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders', 'index');
        Route::prefix('/order')->group(function () {
            Route::post('/create', 'store');
            Route::get('/{uuid}', 'show');
            Route::put('/{uuid}', 'update');
            Route::delete('/{uuid}', 'destroy');
        });
    });

    Route::controller(OrderStatusController::class)->group(function () {
        Route::get('/order-statuses', 'index');
        Route::prefix('/order-status')->group(function () {
            Route::post('/create', 'store');
            Route::get('/{uuid}', 'show');
            Route::put('/{uuid}', 'update');
            Route::delete('/{uuid}', 'destroy');
        });
    });

    Route::controller(PaymentController::class)->prefix('/payments')->group(function () {
        Route::get('/', 'index');
        Route::post('/create', 'store');
        Route::get('/{uuid}', 'show');
        Route::put('/{uuid}', 'update');
        Route::delete('/{uuid}', 'destroy');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index');
        Route::prefix('/product')->group(function () {
            Route::post('/create', 'store');
            Route::get('/{uuid}', 'show');
            Route::put('/{uuid}', 'update');
            Route::delete('/{uuid}', 'destroy');
        });
    });
});
