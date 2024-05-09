<?php

use App\Http\Controllers\API\AccountAPIController;
use App\Http\Controllers\API\Admin\AdminAPIController;
use App\Http\Controllers\API\Admin\AdminGroupController;
use App\Http\Controllers\API\Admin\AdminModuleAPIController;
use App\Http\Controllers\API\Admin\AdminSettingsAPIController;
use App\Http\Controllers\API\Admin\AdminUserAPIController;
use App\Services\Utils\Unsplash\UnsplashService;
use App\Services\Utils\Version\VersionService;
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

    Route::get('errors/{errorCode}', function () {
        if (request()->errorCode < 400 || request()->errorCode > 599) {
            abort(400);
        }

        abort(request()->errorCode);
    });

    Route::prefix('unsplash')->group(function () {
        Route::get('random', [UnsplashService::class, 'getRandomUnsplashImage']);
        Route::get('utm', [UnsplashService::class, 'getUTM']);
    });

    Route::prefix('version')->group(function () {
        Route::get('/dev', fn () => App\Facades\Utils\VersionManager::isDevVersion() ? 'true' : 'false');
        Route::get('/template', [VersionService::class, 'getCurrentTemplateVersion']);
        Route::get('/project', [VersionService::class, 'getCurrentProjectVersion']);
        Route::prefix('remote')->group(function () {
            Route::get('/template', [VersionService::class, 'getRemoteTemplateVersion']);
            Route::get('/project', [VersionService::class, 'getRemoteProjectVersion']);
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::group(['prefix' => 'account'], function () {
            Route::get('/', [AccountAPIController::class, 'getAccount']);

            Route::get('activity', [AccountAPIController::class, 'getActivity']);
            Route::get('permissions', [AccountAPIController::class, 'getPermissions']);
            Route::get('groups', [AccountAPIController::class, 'getGroups']);
            Route::get('avatar', [AccountAPIController::class, 'getAvatar']);
            Route::delete('/', [AccountAPIController::class, 'deleteAccount']);
            Route::post('/', [AccountAPIController::class, 'updateAccount']);
        });

        Route::middleware('role:Super Admin')->group(callback: function () {
            Route::group(['prefix' => 'admin'], function () {
                Route::get('activity', [AdminAPIController::class, 'getActivity']);
                Route::get('admins', [AdminAPIController::class, 'getAdmins']);

                Route::group(['prefix' => 'users'], function () {
                    Route::get('{userId}', [AdminUserAPIController::class, 'getUser']);
                    Route::post('{userId}', [AdminUserAPIController::class, 'updateUser']);
                    Route::delete('{userId}', [AdminUserAPIController::class, 'deleteUser']);
                    Route::post('/', [AdminUserAPIController::class, 'createUser']);
                    Route::get('/', [AdminUserAPIController::class, 'getAllUsers']);
                });

                Route::group(['prefix' => 'groups'], function () {
                    Route::get('{groupId}', [AdminGroupController::class, 'getGroup']);
                    Route::post('{groupId}', [AdminGroupController::class, 'updateGroup']);
                    Route::delete('{groupId}', [AdminGroupController::class, 'deleteGroup']);
                    Route::post('', [AdminGroupController::class, 'createGroup']);
                    Route::get('/', [AdminGroupController::class, 'getAllGroups']);
                });

                Route::group(['prefix' => 'settings'], function () {
                    Route::get('/', [AdminSettingsAPIController::class, 'getAllSettings']);
                    Route::get('{key}', [AdminSettingsAPIController::class, 'getSetting']);
                    Route::post('update/multiple', [AdminSettingsAPIController::class, 'updateSettings']);
                    Route::post('update/single', [AdminSettingsAPIController::class, 'updateSetting']);
                });

                Route::group(['prefix' => 'modules'], function () {
                    Route::get('/', [AdminModuleAPIController::class, 'getAllModules']);
                    Route::get('{moduleName}', [AdminModuleAPIController::class, 'getModule']);
                    Route::post('{moduleName}/enable', [AdminModuleAPIController::class, 'enableModule']);
                    Route::post('{moduleName}/disable', [AdminModuleAPIController::class, 'disableModule']);
                    Route::delete('{moduleName}', [AdminModuleAPIController::class, 'deleteModule']);
                });

            });
        });
    });
});
