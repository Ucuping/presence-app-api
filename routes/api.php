<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PresenceController;
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

Route::prefix('v1')->group(function () {
    // Unauthenticated routes
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
    });

    // Authendicated routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/logout', [AuthController::class, 'logout']);

        Route::prefix('presences')->group(function () {
            Route::get('get-data', [PresenceController::class, 'getData']);
            Route::post('store', [PresenceController::class, 'store']);
        });
    });
});
