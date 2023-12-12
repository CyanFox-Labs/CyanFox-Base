<?php

use App\Http\Controllers\API\Account\AccountAPIController;
use App\Http\Controllers\API\UnsplashAPIController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::get('unsplash', [UnsplashAPIController::class, 'getRandomUnsplashImage']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::group(['prefix' => 'account'], function () {
            Route::get('/', [AccountAPIController::class, 'getAccount']);

            Route::get('activity', [AccountAPIController::class, 'getActivity']);
            Route::get('permissions', [AccountAPIController::class, 'getPermissions']);
            Route::get('roles', [AccountAPIController::class, 'getRoles']);
            Route::post('update', [AccountAPIController::class, 'updateAccount']);
        });
    });
});
