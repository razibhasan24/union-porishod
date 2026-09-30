<?php

use Illuminate\Support\Facades\Route;
use Modules\Applicant\Http\Controllers\ApplicantController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('applicants', ApplicantController::class)->names('applicant');
});
