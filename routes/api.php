<?php

use App\Http\Controllers\Api\ApiVerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiClothesController;
use App\Http\Controllers\Api\ApiCategoryController;
use App\Http\Controllers\Api\ApiLoginController;
use App\Http\Controllers\Api\ApiRegisterController;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\ApiCartController;
use App\Http\Controllers\Api\ApiTransactionController;

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

Route::middleware(['auth:sanctum'])->get('v1/check-auth', function () {
    return response()->json([
        'message' => 'Authenticated',
        'user' => auth()->user()
    ]);
});

Route::prefix('v1')->group(function () {
    // Add this debug route
    Route::get('test-image-path', function () {
        $paths = [
            'storage_path' => storage_path('app/public/images/clothes'),
            'public_path' => public_path('storage/images/clothes'),
            'exists_storage' => file_exists(storage_path('app/public/images/clothes')),
            'exists_public' => file_exists(public_path('storage/images/clothes'))
        ];
        return response()->json($paths);
    });

    // Add this new route before your other routes
    Route::get('assets/images/{folder}/{filename}', [ApiProductController::class, 'serveImage']);

    // Public routes
    Route::post('login', [ApiLoginController::class, 'login']);
    Route::post('register', [ApiRegisterController::class, 'register']);
    Route::post('verify-email', [ApiVerificationController::class, 'verify']);
    Route::post('resend-otp', [ApiVerificationController::class, 'resend']);

    // Product routes
    Route::get('products', [ApiProductController::class, 'index']);
    Route::get('products/{id}', [ApiProductController::class, 'show']);
    Route::get('categories', [ApiProductController::class, 'categories']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [ApiLoginController::class, 'logout']);
        Route::apiResource('clothes', ApiClothesController::class);
        Route::apiResource('categories', ApiCategoryController::class);

        // Cart routes        
        Route::get('cart', [ApiCartController::class, 'index']);
        Route::post('cart/{clothes}', [ApiCartController::class, 'addToCart']);
        Route::patch('cart/{id}', [ApiCartController::class, 'updateQuantity']); // Modified
        Route::delete('cart/{id}', [ApiCartController::class, 'removeItem']); // Modified

        // Transaction routes
        Route::get('transactions', [ApiTransactionController::class, 'index']);
        Route::post('transactions', [ApiTransactionController::class, 'store']);
        Route::get('transactions/{transaction}', [ApiTransactionController::class, 'show']);
        Route::patch('transactions/{transaction}', [ApiTransactionController::class, 'updateStatus']);
        Route::delete('transactions/{transaction}', [ApiTransactionController::class, 'cancel']);
    });

    // ================== JWT Auth ==================

    // Route::group([
    //     'middleware' => 'api',
    //     'prefix' => 'auth'
    // ], function ($router) {
    //     Route::post('login', 'Auth\LoginController@login');
    //     Route::post('logout', 'Auth\LoginController@logout');
    //     Route::post('refresh', 'Auth\LoginController@refresh');
    // });

    // // Protected routes
    // Route::group(['middleware' => ['jwt.auth']], function () {
    //     Route::post('logout', [ApiLoginController::class, 'logout']);
    //     Route::apiResource('clothes', ApiClothesController::class);
    //     Route::apiResource('categories', ApiCategoryController::class);

    //     // Cart routes        
    //     Route::get('cart', [ApiCartController::class, 'index']);
    //     Route::post('cart/{clothes}', [ApiCartController::class, 'addToCart']);
    //     Route::patch('cart/{id}', [ApiCartController::class, 'updateQuantity']); // Modified
    //     Route::delete('cart/{id}', [ApiCartController::class, 'removeItem']); // Modified

    //     // Transaction routes
    //     Route::get('transactions', [ApiTransactionController::class, 'index']);
    //     Route::post('transactions', [ApiTransactionController::class, 'store']);
    //     Route::get('transactions/{transaction}', [ApiTransactionController::class, 'show']);
    //     Route::patch('transactions/{transaction}', [ApiTransactionController::class, 'updateStatus']);
    //     Route::delete('transactions/{transaction}', [ApiTransactionController::class, 'cancel']);
    // });
});
