<?php

use App\Http\Controllers\DistrictController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RegencyController;
use App\Http\Controllers\VillageController;
use Illuminate\Support\Facades\Route;

Route::apiResource('offices', OfficeController::class)->only(['index']);
Route::apiResource('occupations', OccupationController::class)->only(['index']);
Route::apiResource('provinces', ProvinceController::class)->only(['index']);
Route::apiResource('regencies/{id}', RegencyController::class)->only(['index']);
Route::apiResource('districts/{id}', DistrictController::class)->only(['index']);
Route::apiResource('villages/{id}', VillageController::class)->only(['index']);
