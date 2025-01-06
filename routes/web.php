<?php

use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClothesController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
// Public routes
Route::get('/', [ClothesController::class, 'landingPage'])->name('landing');
Route::get('/api-docs', function () {
    return view('docs');
})->name('api.docs');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/clothes/{id}', [ClothesController::class, 'showLanding'])->name('landing.detail');

// Authentication routes 
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register'); // Add this line
Route::post('register', [RegisterController::class, 'register'])->name('register.submit');
Route::get('verify', [VerificationController::class, 'show'])->name('verify.show'); // Add this line
Route::post('verify', [VerificationController::class, 'verify'])->name('verify.verify');
Route::post('resend-otp', [VerificationController::class, 'resend'])->name('verify.resend');

// Add this route outside the jwt.auth middleware group
Route::get('/api/user', function () {
    return response()->json(auth()->user());
});

// Protected routes with JWT verification
Route::middleware(['web'])->group(function () {
    Route::middleware(['jwt.verify'])->group(function () {
        // Admin routes
        Route::group([
            'prefix' => 'admin',
            'middleware' => ['admin', 'jwt.verify'],
            'as' => 'admin.'
        ], function () {
            Route::get('/dashboard', function () {
                return view('admin.dashboard');
            })->name('dashboard');

            Route::resource('clothes', ClothesController::class);
            Route::resource('categories', CategoryController::class);

            // Admin transactions
            Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
            Route::get('/transactions/{transaction}', [AdminTransactionController::class, 'show'])->name('transactions.show');
            Route::patch('/transactions/{transaction}/status', [AdminTransactionController::class, 'updateStatus'])->name('transactions.update-status');

            // Backup routes
            Route::prefix('backup')->group(function () {
                Route::get('/', [BackupController::class, 'index'])->name('backup.index');
                Route::post('/database', [BackupController::class, 'backupDatabase'])->name('backup.database');
                Route::get('/{backup}/restore', [BackupController::class, 'restoreDatabase'])->name('backup.restore');
                Route::get('/{backup}/download', [BackupController::class, 'downloadBackup'])->name('backup.download');
                Route::delete('/{backup}', [BackupController::class, 'deleteBackup'])->name('backup.delete');
                Route::get('/project', [BackupController::class, 'backupProject'])->name('backup.project');
                Route::get('/check-restore-status', [BackupController::class, 'checkRestoreStatus'])->name('backup.check-restore-status');
            });
        });

        // Cart routes - keep these inside jwt.verify middleware
        Route::prefix('cart')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('cart.index');
            Route::post('/add/{id}', [CartController::class, 'add'])->name('cart.add');
            Route::patch('/update/{cartItem}', [CartController::class, 'updateQuantity']);
            Route::delete('/remove/{cartItem}', [CartController::class, 'removeItem']);
        });

        // User routes
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        // Checkout routes
        Route::prefix('checkout')->group(function () {
            Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
            Route::post('/', [CheckoutController::class, 'store'])->name('checkout.store');
            Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
        })->middleware(['jwt.verify']);

        // User transactions
        Route::prefix('user/transactions')->middleware(['jwt.verify'])->group(function () {
            Route::get('/', [TransactionController::class, 'index'])->name('user.transactions.index');
            Route::get('/{transaction}', [TransactionController::class, 'show'])->name('user.transactions.show');
            Route::post('/', [TransactionController::class, 'store'])->name('user.transactions.store');
            Route::post('/{transaction}/cancel', [TransactionController::class, 'cancel'])->name('user.transactions.cancel');
        });
    });
});

// Remove the duplicate route and keep only this one
Route::get('/api/user', function () {
    return response()->json(auth()->user());
});

// Remove default Laravel auth routes as we're using JWT
// Auth::routes();