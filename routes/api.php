<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RegencyController;
use App\Http\Controllers\VillageController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    // Register active depend on config('app.enable_register') value.
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'getUser']);
    Route::resource('provinces', ProvinceController::class)->only(['index', 'show']);
    Route::resource('regencies', RegencyController::class)->only(['index', 'show']);
    Route::resource('districts', DistrictController::class)->only(['index', 'show']);
    Route::resource('villages', VillageController::class)->only(['index', 'show']);
});
