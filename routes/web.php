<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClothesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('clothes', ClothesController::class);
    Route::resource('categories', CategoryController::class);
});

Route::get('/', [ClothesController::class, 'landingPage'])->name('home');
Route::get('/clothes/{id}', [ClothesController::class, 'showLanding'])->name('landing.detail');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
