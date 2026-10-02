<?php

use Illuminate\Support\Facades\Route;
use Modules\Applicant\Http\Controllers\DashboardController;
use Modules\Applicant\Http\Controllers\ApplicationController;
use Modules\Applicant\Http\Controllers\ProfileController;

Route::middleware(['web', 'auth', 'user_type:applicant'])
    ->prefix('applicant')
    ->name('applicant.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Applications
        Route::get('applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::get('applications/create', [ApplicationController::class, 'create'])->name('applications.create');
        Route::post('applications', [ApplicationController::class, 'store'])->name('applications.store');
        Route::get('applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
        Route::get('applications/{application}/receipt', [ApplicationController::class, 'receipt'])->name('applications.receipt');
        Route::get('applications/{application}/print', [ApplicationController::class, 'print'])->name('applications.print');
        Route::post('applications/{application}/request-early-print', [ApplicationController::class, 'requestEarlyPrint'])->name('applications.request-early-print');

        // Profile
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    });