<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\ApplicantPaymentController;
use Modules\Payment\Http\Controllers\AdminPaymentController;

// ===================== APPLICANT PAYMENT ROUTES =====================
Route::middleware(['web', 'auth', 'user_type:applicant,super_admin'])
    ->prefix('applicant/payment')
    ->name('applicant.payment.')
    ->group(function () {
        Route::get('{application}', [ApplicantPaymentController::class, 'show'])->name('show');
        Route::post('{application}/initiate', [ApplicantPaymentController::class, 'initiate'])->name('initiate');
        Route::get('callback/{payment}', [ApplicantPaymentController::class, 'callback'])->name('callback');
        Route::get('success/{payment}', [ApplicantPaymentController::class, 'success'])->name('success');
        Route::get('failed/{payment}', [ApplicantPaymentController::class, 'failed'])->name('failed');
    });

// ===================== ADMIN PAYMENT ROUTES =====================
Route::middleware(['web', 'auth', 'user_type:super_admin,chairman,secretary,accountant,certificate_officer,office_staff'])
    ->prefix('admin/payments')
    ->name('payment.admin.')
    ->group(function () {
        Route::get('/', [AdminPaymentController::class, 'index'])->name('index');
        Route::get('cash-entry', [AdminPaymentController::class, 'cashEntryForm'])->name('cash-entry');
        Route::post('cash-entry', [AdminPaymentController::class, 'recordCash'])->name('cash-store');
        Route::get('{payment}', [AdminPaymentController::class, 'show'])->name('show');
        Route::get('{payment}/receipt', [AdminPaymentController::class, 'receipt'])->name('receipt');
    });