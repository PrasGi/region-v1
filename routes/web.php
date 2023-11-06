<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RegencyController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\VillageController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        // Route::get('/register', [AuthController::class, 'registerForm'])->name('register.form');
        // Route::post('/register', [AuthController::class, 'register'])->name('register');
    });
});

Route::middleware('auth')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/province', [ProvinceController::class, 'index'])->name('province.index');
    Route::get('/regency', [RegencyController::class, 'index'])->name('regency.index');
    Route::get('/district', [DistrictController::class, 'index'])->name('district.index');
    Route::get('/village', [VillageController::class, 'index'])->name('village.index');

    Route::get('/token', [TokenController::class, 'index'])->name('token.index');
    Route::post('/token', [TokenController::class, 'store'])->name('token.store');
    Route::delete('/token/{id}', [TokenController::class, 'destroy'])->name('token.destroy');

    Route::middleware('role:1')->group(function () {
        Route::post('/province', [ProvinceController::class, 'store'])->name('province.store');
        Route::get('/province/update/{id}', [ProvinceController::class, 'updateForm'])->name('province.update.form');
        Route::put('/province/{id}', [ProvinceController::class, 'update'])->name('province.update');
        Route::delete('/province/{id}', [ProvinceController::class, 'destroy'])->name('province.destroy');

        Route::post('/regency', [RegencyController::class, 'store'])->name('regency.store');
        Route::get('/regency/update/{id}', [RegencyController::class, 'updateForm'])->name('regency.update.form');
        Route::put('/regency/{id}', [RegencyController::class, 'update'])->name('regency.update');
        Route::delete('/regency/{id}', [RegencyController::class, 'destroy'])->name('regency.destroy');

        Route::post('/district', [DistrictController::class, 'store'])->name('district.store');
        Route::get('/district/update/{id}', [DistrictController::class, 'updateForm'])->name('district.update.form');
        Route::put('/district/{id}', [DistrictController::class, 'update'])->name('district.update');
        Route::delete('/district/{id}', [DistrictController::class, 'destroy'])->name('district.destroy');

        Route::post('/village', [VillageController::class, 'store'])->name('village.store');
        Route::get('/village/update/{id}', [VillageController::class, 'updateForm'])->name('village.update.form');
        Route::put('/village/{id}', [VillageController::class, 'update'])->name('village.update');
        Route::delete('/village/{id}', [VillageController::class, 'destroy'])->name('village.destroy');

        Route::get('/map/province/{province}', [MapController::class, 'provinceIndex'])->name('map.province.index');

        Route::post('/import/provinces', [ProvinceController::class, 'import'])->name('province.import');
    });
});