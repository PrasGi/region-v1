<?php

use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\ProvinceController;
use App\Http\Controllers\Api\RegencyController;
use App\Http\Controllers\Api\VillageController;
use App\Http\Controllers\MapController;
use Illuminate\Http\Request;
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

Route::middleware('xtoken')->group(function () {
    Route::get('/provinces', [ProvinceController::class, 'index']);
    Route::get('/regencies', [RegencyController::class, 'index']);
    Route::get('/districts', [DistrictController::class, 'index']);
    Route::get('/villages', [VillageController::class, 'index']);
});

Route::post('/province/update/region', [MapController::class, 'updateProvince']);
Route::post('/import/province/location', [MapController::class, 'importLocationsProvince']);
