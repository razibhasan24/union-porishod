<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\VillageController;
use Modules\Core\Http\Controllers\WardController;

Route::middleware(['api', 'auth:sanctum'])->prefix('api/core')->name('api.core.')->group(function () {
    Route::get('wards/{ward}/villages', [VillageController::class, 'getByWard']);
    Route::get('unions', fn() => \Modules\Core\Models\Union::all());
    Route::get('wards', fn() => \Modules\Core\Models\Ward::all());
});