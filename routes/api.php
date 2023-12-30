<?php

use App\Http\Controllers\API\Account\AccountAPIController;
use App\Http\Controllers\API\Admin\AdminAPIController;
use App\Http\Controllers\API\Admin\Alerts\AdminAlertAPIController;
use App\Http\Controllers\API\Admin\Roles\AdminRoleAPIController;
use App\Http\Controllers\API\Admin\Users\AdminUserAPIController;
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

        Route::middleware('role:Super Admin')->group(function () {
            Route::group(['prefix' => 'admin'], function () {
                Route::get('activity', [AdminAPIController::class, 'getActivity']);
                Route::get('admins', [AdminAPIController::class, 'getAdmins']);

                Route::group(['prefix' => 'users'], function () {
                    Route::get('{userId}', [AdminUserAPIController::class, 'getUser']);
                    Route::post('{userId}/update', [AdminUserAPIController::class, 'updateUser']);
                    Route::delete('{userId}/delete', [AdminUserAPIController::class, 'deleteUser']);
                    Route::post('create', [AdminUserAPIController::class, 'createUser']);
                    Route::get('/', [AdminUserAPIController::class, 'getAllUsers']);
                });

                Route::group(['prefix' => 'roles'], function () {
                    Route::get('{roleId}', [AdminRoleAPIController::class, 'getRole']);
                    Route::post('{roleId}/update', [AdminRoleAPIController::class, 'updateRole']);
                    Route::delete('{roleId}/delete', [AdminRoleAPIController::class, 'deleteRole']);
                    Route::post('create', [AdminRoleAPIController::class, 'createRole']);
                    Route::get('/', [AdminRoleAPIController::class, 'getAllRoles']);
                });

                Route::group(['prefix' => 'alerts'], function () {
                    Route::get('{alertId}', [AdminAlertAPIController::class, 'getAlert']);
                    Route::post('{alertId}/update', [AdminAlertAPIController::class, 'updateAlert']);
                    Route::delete('{alertId}/delete', [AdminAlertAPIController::class, 'deleteAlert']);
                    Route::post('create', [AdminAlertAPIController::class, 'createAlert']);
                    Route::get('/', [AdminAlertAPIController::class, 'getAllAlerts']);
                });
            });
        });
    });
});
