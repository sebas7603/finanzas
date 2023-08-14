<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\ExternalController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\SubscriptionController;
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

Route::middleware('auth:api')->group(function() {
    Route::controller(FinancialController::class)->prefix('financials')->name('financials.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'create')->name('create');
        Route::get('/{id}', 'view')->name('view');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'delete')->name('delete');

        Route::middleware('check.financial')->prefix('{financial_id}')->group(function() {
            Route::controller(MovementController::class)->prefix('movements')->name('movements.')->group(function() {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'create')->name('create');
                Route::get('/{id}', 'view')->name('view');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'delete')->name('delete');
            });

            Route::controller(AccountController::class)->prefix('accounts')->name('accounts.')->group(function() {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'create')->name('create');
                Route::get('/{id}', 'view')->name('view');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'delete')->name('delete');
            });

            Route::controller(CardController::class)->prefix('cards')->name('cards.')->group(function() {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'create')->name('create');
                Route::get('/{id}', 'view')->name('view');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'delete')->name('delete');
            });

            Route::controller(SubscriptionController::class)->prefix('subscriptions')->name('subscriptions.')->group(function() {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'create')->name('create');
                Route::get('/{id}', 'show')->name('show');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'delete')->name('delete');
            });

            Route::controller(DebtController::class)->prefix('debts')->name('debts.')->group(function() {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'create')->name('create');
                Route::get('/{id}', 'show')->name('show');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'delete')->name('delete');
            });
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

    Route::controller(ExternalController::class)->prefix('/externals')->name('externals.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'create')->name('create');
        Route::get('/{slug}', 'view')->name('view');
        Route::put('/{slug}', 'update')->name('update');
        Route::delete('/{slug}', 'delete')->name('delete');
    });

    Route::controller(BankController::class)->prefix('/banks')->name('banks.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'create')->name('create');
        Route::get('/{slug}', 'view')->name('view');
        Route::put('/{slug}', 'update')->name('update');
        Route::delete('/{slug}', 'delete')->name('delete');
    });
});

