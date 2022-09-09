<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {

    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');

    Route::group(['middleware' => ['auth:sanctum']], function() {

        Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh'])->name('auth.refresh');
        Route::get('user', [\App\Http\Controllers\AuthController::class, 'user'])->name('auth.user');
    });
});

Route::group(['middleware' => ['auth:sanctum']], function() {

    Route::group(['prefix' => 'dashboard'], function () {

        Route::get('countCategories', [\App\Http\Controllers\DashboardController::class, 'countCategories'])->name('dashboard.countCategories');
        Route::get('countProducts', [\App\Http\Controllers\DashboardController::class, 'countProducts'])->name('dashboard.countProducts');
    });

    Route::group(['prefix' => 'users'], function () {

        Route::put('/', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::post('avatar', [\App\Http\Controllers\UserController::class, 'avatar'])->name('users.update.avatar');
    });

    Route::resource('categories', \App\Http\Controllers\CategoryController::class)->only([
        'index', 'store', 'show', 'update', 'destroy'
    ]);

    Route::group(['prefix' => 'categories'], function () {

        Route::put('/toggleActive/{category}', [\App\Http\Controllers\CategoryController::class, 'toggleActive'])->name('categories.toggleActive');
    });

    Route::resource('products', \App\Http\Controllers\ProductController::class)->only([
        'index', 'store', 'show', 'update', 'destroy'
    ]);

    Route::group(['prefix' => 'products'], function () {

        Route::put('/toggleActive/{product}', [\App\Http\Controllers\ProductController::class, 'toggleActive'])->name('products.toggleActive');
        Route::post('/activeMany', [\App\Http\Controllers\ProductController::class, 'activeMany'])->name('products.activeMany');
        Route::post('/inactiveMany', [\App\Http\Controllers\ProductController::class, 'inactiveMany'])->name('products.inactiveMany');
        Route::post('/destroyMany', [\App\Http\Controllers\ProductController::class, 'destroyMany'])->name('products.destroyMany');
    });

});
