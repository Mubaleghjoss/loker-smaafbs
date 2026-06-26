<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\ApplicantController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Frontend\ApplicationController;
use App\Http\Controllers\Frontend\LandingController;
use App\Http\Controllers\Frontend\StatusController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');

Route::get('/daftar', [ApplicationController::class, 'create'])->name('applications.create');
Route::post('/daftar', [ApplicationController::class, 'store'])->name('applications.store');
Route::get('/sukses/{code}', [ApplicationController::class, 'success'])->name('applications.success');

Route::get('/cek-status', [StatusController::class, 'form'])->name('status.form');
Route::post('/cek-status', [StatusController::class, 'check'])->name('status.check');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.submit');

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Public preview (tanpa login)
    Route::get('applicants/{application}/preview/{type}', [ApplicantController::class, 'previewFile'])
        ->name('applicants.preview');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [DashboardController::class, 'redirectHome'])->name('home');

        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('dashboard', [DashboardController::class, 'index'])
            ->middleware('admin.permission:dashboard.view')
            ->name('dashboard');

        Route::resource('positions', PositionController::class)
            ->middleware('admin.permission:positions.manage')
            ->except(['show']);
        Route::post('positions/{position}/toggle', [PositionController::class, 'toggleStatus'])
            ->middleware('admin.permission:positions.manage')
            ->name('positions.toggle');

        Route::get('applicants', [ApplicantController::class, 'index'])
            ->middleware('admin.permission:applicants.view')
            ->name('applicants.index');
        Route::get('applicants/{application}', [ApplicantController::class, 'show'])
            ->middleware('admin.permission:applicants.view')
            ->name('applicants.show');

        Route::post('applicants/{application}/status', [ApplicantController::class, 'updateStatus'])
            ->middleware('admin.permission:applicants.update')
            ->name('applicants.status');

        Route::get('applicants/{application}/files/{type}', [ApplicantController::class, 'downloadFile'])
            ->middleware('admin.permission:applicants.download')
            ->name('applicants.files');



        Route::get('applicants/export/csv', [ApplicantController::class, 'exportCsv'])
            ->middleware('admin.permission:applicants.export')
            ->name('applicants.export.csv');

        Route::get('settings', [SettingController::class, 'edit'])
            ->middleware('admin.permission:settings.manage')
            ->name('settings.edit');
        Route::post('settings', [SettingController::class, 'update'])
            ->middleware('admin.permission:settings.manage')
            ->name('settings.update');
        Route::post('settings/branding', [SettingController::class, 'updateBranding'])
            ->middleware('admin.permission:settings.manage')
            ->name('settings.branding');

        Route::resource('admin-users', AdminUserController::class)
            ->middleware('admin.permission:admin_users.manage')
            ->except(['show']);

        // Backup & Export
        Route::get('backup/sqlite', [BackupController::class, 'downloadSqlite'])
            ->middleware('admin.permission:settings.manage')
            ->name('backup.sqlite');
        Route::get('backup/mysql', [BackupController::class, 'exportMysql'])
            ->middleware('admin.permission:settings.manage')
            ->name('backup.mysql');
    });
});
