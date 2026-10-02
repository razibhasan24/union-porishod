<?php

use Illuminate\Support\Facades\Route;
use Modules\Certificate\Http\Controllers\CertificateTypeController;
use Modules\Certificate\Http\Controllers\CertificateApplicationController;

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
    });