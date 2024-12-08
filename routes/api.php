<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiClothesController;
use App\Http\Controllers\Api\ApiCategoryController;
use App\Http\Controllers\Api\ApiLoginController;
use App\Http\Controllers\Api\ApiRegisterController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('login', [ApiLoginController::class, 'login']);
    Route::post('register', [ApiRegisterController::class, 'register']);
    // Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [ApiLoginController::class, 'logout']);
    Route::apiResource('clothes', ApiClothesController::class);
    Route::apiResource('categories', ApiCategoryController::class);
    // });
});
