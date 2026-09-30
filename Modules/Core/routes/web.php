<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\DashboardController;
use Modules\Core\Http\Controllers\PermissionController;
use Modules\Core\Http\Controllers\RoleController;
use Modules\Core\Http\Controllers\SettingController;
use Modules\Core\Http\Controllers\UnionController;
use Modules\Core\Http\Controllers\UserController;
use Modules\Core\Http\Controllers\VillageController;
use Modules\Core\Http\Controllers\WardController;

Route::middleware(['web', 'auth', 'user_type:super_admin,chairman,secretary,ward_member,female_member,accountant,certificate_officer,office_staff'])
    ->prefix('admin')
    ->name('core.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Unions
        Route::resource('unions', UnionController::class);

        // Wards
        Route::resource('wards', WardController::class);

        // Villages
        Route::resource('villages', VillageController::class);
        Route::get('wards/{ward}/villages', [VillageController::class, 'getByWard'])->name('wards.villages');

        // Users
        Route::resource('users', UserController::class);
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Roles
        Route::resource('roles', RoleController::class);

        // Permissions
        Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');

        // Settings
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });