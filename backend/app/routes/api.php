<?php

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

Route::group(['prefix' => 'auth'], function () {

    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');

    Route::group(['middleware' => ['auth:api']], function() {

        Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh'])->name('auth.refresh');
        Route::get('user', [\App\Http\Controllers\AuthController::class, 'user'])->name('auth.user');
    });
});

Route::group(['middleware' => ['auth:api']], function() {

    Route::group(['prefix' => 'dashboard'], function () {

        Route::get('contarCategorias', [\App\Http\Controllers\DashboardController::class, 'contarCategorias'])->name('dashboard.contarCategorias');
        Route::get('contarProdutos', [\App\Http\Controllers\DashboardController::class, 'contarProdutos'])->name('dashboard.contarProdutos');
    });

    Route::group(['prefix' => 'usuarios'], function () {

        Route::put('/', [\App\Http\Controllers\UsuarioController::class, 'update'])->name('usuarios.update');
        Route::post('avatar', [\App\Http\Controllers\UsuarioController::class, 'avatar'])->name('usuarios.update.avatar');
    });

    Route::resource('categorias', \App\Http\Controllers\CategoriaController::class)->only([
        'index', 'store', 'show', 'update', 'destroy'
    ]);

    Route::group(['prefix' => 'categorias'], function () {

        Route::put('/toggleActive/{categoria}', [\App\Http\Controllers\CategoriaController::class, 'toggleActive'])->name('categorias.toggleActive');
    });

});
