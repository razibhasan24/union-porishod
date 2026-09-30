<?php

use Illuminate\Support\Facades\Route;
use Modules\Citizen\Http\Controllers\CitizenController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('citizens', CitizenController::class)->names('citizen');
});
