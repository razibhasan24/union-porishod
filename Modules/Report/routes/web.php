<?php

use Illuminate\Support\Facades\Route;
use Modules\Report\Http\Controllers\DashboardController;
use Modules\Report\Http\Controllers\ReportController;

Route::middleware(['web', 'auth'])
    ->prefix('admin/reports')
    ->name('report.')
    ->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Daily Report
        Route::get('daily', [ReportController::class, 'daily'])->name('daily');
        Route::get('daily/pdf', [ReportController::class, 'dailyPdf'])->name('daily.pdf');
        Route::get('daily/excel', [ReportController::class, 'dailyExcel'])->name('daily.excel');

        // Monthly Report
        Route::get('monthly', [ReportController::class, 'monthly'])->name('monthly');
        Route::get('monthly/pdf', [ReportController::class, 'monthlyPdf'])->name('monthly.pdf');
        Route::get('monthly/excel', [ReportController::class, 'monthlyExcel'])->name('monthly.excel');

        // Revenue Report
        Route::get('revenue', [ReportController::class, 'revenue'])->name('revenue');
        Route::get('revenue/pdf', [ReportController::class, 'revenuePdf'])->name('revenue.pdf');
        Route::get('revenue/excel', [ReportController::class, 'revenueExcel'])->name('revenue.excel');

        // Ward Report
        Route::get('ward', [ReportController::class, 'ward'])->name('ward');
        Route::get('ward/pdf', [ReportController::class, 'wardPdf'])->name('ward.pdf');
        Route::get('ward/excel', [ReportController::class, 'wardExcel'])->name('ward.excel');

        // Type Report
        Route::get('type', [ReportController::class, 'type'])->name('type');
        Route::get('type/pdf', [ReportController::class, 'typePdf'])->name('type.pdf');
        Route::get('type/excel', [ReportController::class, 'typeExcel'])->name('type.excel');
    });