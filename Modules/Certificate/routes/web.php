<?php

use Illuminate\Support\Facades\Route;
use Modules\Certificate\Http\Controllers\CertificateTypeController;
use Modules\Certificate\Http\Controllers\CertificateApplicationController;
use Modules\Certificate\Http\Controllers\VerificationController;
use Modules\Certificate\Http\Controllers\PrintController;

// ================== PUBLIC VERIFICATION (No auth) ==================
Route::middleware(['web'])
    ->name('verify.')
    ->group(function () {
        Route::get('verify/certificate', [VerificationController::class, 'form'])->name('form');
        Route::get('verify/certificate/{code}', [VerificationController::class, 'verify'])->name('certificate');
    });

// ================== ADMIN ROUTES ==================
Route::middleware(['web', 'auth'])
    ->prefix('admin')
    ->name('certificate.')
    ->group(function () {

        // ============ Certificate Types ============
        Route::resource('certificate-types', CertificateTypeController::class)
            ->names('types')
            ->parameters(['certificate-types' => 'type']);

        // ============ Certificate Applications ============
        Route::get('certificate-applications', [CertificateApplicationController::class, 'index'])
            ->name('applications.index');

        Route::get('certificate-applications/pending', [CertificateApplicationController::class, 'pendingForWard'])
            ->name('applications.pending');

        Route::get('certificate-applications/pending-chairman', [CertificateApplicationController::class, 'pendingForChairman'])
            ->name('applications.pending-chairman');

        Route::get('certificate-applications/{application}', [CertificateApplicationController::class, 'show'])
            ->name('applications.show');

        // ============ Ward Member Actions ============
        Route::post('certificate-applications/{application}/ward-recommend', [CertificateApplicationController::class, 'wardRecommend'])
            ->name('applications.ward-recommend');

        Route::post('certificate-applications/{application}/ward-reject', [CertificateApplicationController::class, 'wardReject'])
            ->name('applications.ward-reject');

        // ============ Chairman Actions ============
        Route::post('certificate-applications/{application}/chairman-approve', [CertificateApplicationController::class, 'chairmanApprove'])
            ->name('applications.chairman-approve');

        Route::post('certificate-applications/{application}/chairman-reject', [CertificateApplicationController::class, 'chairmanReject'])
            ->name('applications.chairman-reject');

        Route::post('certificate-applications/{application}/chairman-hold', [CertificateApplicationController::class, 'chairmanHold'])
            ->name('applications.chairman-hold');

        Route::post('certificate-applications/{application}/allow-print', [CertificateApplicationController::class, 'allowPrint'])
            ->name('applications.allow-print');

        // ============ Print / PDF ============
        Route::get('certificate-applications/{application}/print-pdf', [PrintController::class, 'printPdf'])
            ->name('applications.print-pdf');

        Route::get('certificate-applications/{application}/download-pdf', [PrintController::class, 'downloadPdf'])
            ->name('applications.download-pdf');

        Route::get('certificate-applications/{application}/preview-pdf', [PrintController::class, 'previewPdf'])
            ->name('applications.preview-pdf');
    });