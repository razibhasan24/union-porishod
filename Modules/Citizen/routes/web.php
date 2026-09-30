<?php

use Illuminate\Support\Facades\Route;
use Modules\Citizen\Http\Controllers\CitizenController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('citizens', CitizenController::class)->names('citizen');
});
