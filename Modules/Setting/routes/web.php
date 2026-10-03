<?php

use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\SmsLogController;
use Modules\Setting\Http\Controllers\SmsTemplateController;
use Modules\Setting\Http\Controllers\SmsSendController;

Route::middleware(['web', 'auth', 'user_type:super_admin,chairman,secretary'])
    ->prefix('admin/settings')
    ->name('setting.')
    ->group(function () {

        // ============ SMS Logs ============
        Route::get('sms-logs', [SmsLogController::class, 'index'])->name('sms-logs.index');
        Route::get('sms-logs/{log}', [SmsLogController::class, 'show'])->name('sms-logs.show');

        // ============ SMS Templates ============
        Route::get('sms-templates', [SmsTemplateController::class, 'index'])->name('sms-templates.index');
        Route::get('sms-templates/{template}/edit', [SmsTemplateController::class, 'edit'])->name('sms-templates.edit');
        Route::put('sms-templates/{template}', [SmsTemplateController::class, 'update'])->name('sms-templates.update');

        // ============ Send SMS manually ============
        Route::get('sms-send', [SmsSendController::class, 'form'])->name('sms-send.form');
        Route::post('sms-send', [SmsSendController::class, 'send'])->name('sms-send.store');
    });