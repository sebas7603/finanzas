<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
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

Route::controller(AuthController::class)->group(function() {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('refresh', 'refresh');
    Route::post('logout', 'logout');
});

Route::middleware('auth')->group(function() {
    Route::controller(FinancialController::class)->prefix('financials')->name('financials.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'create')->name('create');
        Route::get('/{id}', 'view')->name('view');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'delete')->name('delete');

        Route::controller(MovementController::class)->prefix('/{financial_id}/movements')->middleware('check.financial')->name('movements.')->group(function() {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'create')->name('create');
            Route::get('/{id}', 'view')->name('view');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'delete')->name('delete');
        });
    });

    Route::controller(CategoryController::class)->prefix('/categories')->name('categories.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'create')->name('create');
        Route::get('/{slug}', 'view')->name('view');
        Route::put('/{slug}', 'update')->name('update');
        Route::delete('/{slug}', 'delete')->name('delete');
    });

    Route::controller(TagController::class)->prefix('/tags')->name('tags.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'create')->name('create');
        Route::get('/{slug}', 'view')->name('view');
        Route::put('/{slug}', 'update')->name('update');
        Route::delete('/{slug}', 'delete')->name('delete');
    });
});

