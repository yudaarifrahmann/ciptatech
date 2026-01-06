<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// PIC
use App\Http\Controllers\PIC\DashboardController as PicDashboardController;
use App\Http\Controllers\PIC\ReportController as PicReportController;
use App\Http\Controllers\PIC\ProfileController;
use App\Http\Controllers\Pic\TaskReportController;

// Supervisor
use App\Http\Controllers\Supervisor\DashboardController as SupervisorDashboardController;
use App\Http\Controllers\Supervisor\MonitoringController;
use App\Http\Controllers\Supervisor\ReportController as SupervisorReportController;
use App\Http\Controllers\Supervisor\UserController;

// Superadmin
use App\Http\Controllers\Superadmin\DivisionController;
use App\Http\Controllers\Superadmin\MonitoringController as SuperadminMonitoringController;
use App\Http\Controllers\Superadmin\UserController as SuperadminUserController;
use App\Http\Controllers\Superadmin\DashboardController as SuperadminDashboardController;

// ================= ROOT =================
Route::get('/', fn () => redirect()->route('login'));

// ================= AUTH =================
Route::get('/login', [LoginController::class, 'show'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'authenticate'])
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ================= PIC =================
Route::middleware(['auth', 'role:PIC'])
    ->prefix('pic')
    ->name('pic.')
    ->group(function () {

        Route::get('/', [PicDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/report/create', [PicReportController::class, 'create'])
            ->name('report.create');

        Route::post('/report', [TaskReportController::class, 'store'])
            ->name('report.store');

        Route::get('/report/history', [PicReportController::class, 'history'])
    ->name('report.history');

        Route::get('/profile', [ProfileController::class, 'index'])
            ->name('profile');

            Route::put('/profile', [ProfileController::class, 'update'])
    ->name('pic.profile.update');

            Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::put('/profile/password', [ProfileController::class, 'changePassword'])
    ->name('pic.profile.password');

    Route::post('/profile/2fa', [ProfileController::class, 'toggle2FA'])
    ->name('pic.profile.2fa');

Route::middleware(['auth', 'verified.custom'])
    ->prefix('pic')
    ->group(function () {
        Route::get('/profile', [ProfileController::class, 'index']);
    });
    });

// ================= SUPERVISOR =================
Route::middleware(['auth', 'role:supervisor'])
    ->prefix('supervisor')
    ->name('supervisor.')
    ->group(function () {

        Route::get('/', [SupervisorDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/monitoring', [MonitoringController::class, 'index'])
            ->name('monitoring');

        Route::get('/monitoring/{task}', [MonitoringController::class, 'show'])
            ->name('monitoring.show');

        Route::post('/monitoring/{task}/comment', [MonitoringController::class, 'comment'])
    ->name('monitoring.comment');

        Route::post('/monitoring/{task}/revision', [MonitoringController::class, 'revision'])
            ->name('monitoring.revision');

        Route::post('/supervisor/tasks/{task}/update-status', [MonitoringController::class, 'updateStatus'])->name('supervisor.tasks.updateStatus');

        Route::get('/reports', [SupervisorReportController::class, 'index'])
            ->name('reports');

        Route::get('/users/create', [UserController::class, 'create'])
            ->name('users.create');

        Route::post('/users', [UserController::class, 'store'])
            ->name('users.store');
    });

// ================= SUPERADMIN =================
Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        Route::get('/', [SuperadminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/users', [SuperadminUserController::class, 'index'])
            ->name('users.index');
        Route::get('/users/create', [SuperadminUserController::class, 'create'])
            ->name('users.create');
        Route::post('/users', [SuperadminUserController::class, 'store'])
            ->name('users.store');
        Route::get('/users/{id}/edit', [SuperadminUserController::class, 'edit'])
            ->name('users.edit');
        Route::put('/users/{id}', [SuperadminUserController::class, 'update'])
            ->name('users.update');
        Route::delete('/users/{id}', [SuperadminUserController::class, 'destroy'])
            ->name('users.destroy');

        // Manajemen Divisi
        Route::get('/divisions', [DivisionController::class, 'index'])
            ->name('divisions.index');

        // Monitoring Sistem
        Route::get('/monitoring', [SuperadminMonitoringController::class, 'index'])
    ->name('monitoring');
    });
