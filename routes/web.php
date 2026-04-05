<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// PIC
use App\Http\Controllers\PIC\DashboardController as PicDashboardController;
use App\Http\Controllers\PIC\ReportController as PicReportController;
use App\Http\Controllers\PIC\ProfileController;
use App\Http\Controllers\PIC\TaskReportController;
use App\Http\Controllers\PIC\DailyReportController;
use App\Http\Controllers\PIC\TaskController as PicTaskController;

// Supervisor
use App\Http\Controllers\Supervisor\DashboardController as SupervisorDashboardController;
use App\Http\Controllers\Supervisor\MonitoringController;
use App\Http\Controllers\Supervisor\ReportController as SupervisorReportController;
use App\Http\Controllers\Supervisor\UserController;
use App\Http\Controllers\Supervisor\TaskController as SupervisorTaskController;
use App\Http\Controllers\Supervisor\ProfileController as SupervisorProfileController;
use App\Http\Controllers\Supervisor\FormBuilderController;

// Superadmin
use App\Http\Controllers\Superadmin\DivisionController;
use App\Http\Controllers\Superadmin\MonitoringController as SuperadminMonitoringController;
use App\Http\Controllers\Superadmin\UserController as SuperadminUserController;
use App\Http\Controllers\Superadmin\DashboardController as SuperadminDashboardController;
use App\Http\Controllers\Superadmin\ProfileController as SuperadminProfileController;
use App\Http\Controllers\LandingController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'show'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'authenticate'])
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/register/superadmin', [RegisterController::class, 'showRegistrationForm'])
    ->middleware('guest')
    ->name('register.superadmin');

Route::post('/register/superadmin', [RegisterController::class, 'register'])
    ->middleware('guest')
    ->name('register.superadmin.post');

/*
|--------------------------------------------------------------------------
| PIC
|--------------------------------------------------------------------------
*/
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

        Route::get('/report/{id}', [PicReportController::class, 'show'])
            ->name('report.show');

        Route::get('/report/{id}/edit', [PicReportController::class, 'edit'])
            ->name('report.edit');

        Route::put('/report/{id}', [PicReportController::class, 'update'])
            ->name('report.update');

        // PROFILE
        Route::get('/profile', [ProfileController::class, 'index'])
            ->name('profile');

        Route::put('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::put('/profile/password', [ProfileController::class, 'changePassword'])
            ->name('profile.password');

        Route::get('/profile/login-activity', [ProfileController::class, 'loginActivity'])
            ->name('profile.loginActivity');

        Route::post('/profile/2fa', [ProfileController::class, 'toggle2FA'])
            ->name('profile.2fa');

        Route::get('/email/verify', function () {
            return view('auth.verify-email');
        })->name('verification.notice');

        // DAILY REPORT
        Route::get('/daily-report', [DailyReportController::class, 'index'])
            ->name('daily-report.index');

        Route::post('/daily-report', [DailyReportController::class, 'store'])
            ->name('daily-report.store');

        // TASKS
        Route::get('/tasks', [PicTaskController::class, 'index'])
            ->name('tasks.index');

        Route::get('/tasks/{task}', [PicTaskController::class, 'show'])
            ->name('tasks.show');

        Route::post('/tasks/{task}/submit', [PicTaskController::class, 'submitWork'])
            ->name('tasks.submit');

        Route::post('/tasks/{task}/complete', [PicTaskController::class, 'completeTaskItem'])
            ->name('tasks.complete');

        Route::get('/tasks/progress/stats', [PicTaskController::class, 'getSubmissionProgress'])
            ->name('tasks.progress');

        // NOTIFICATIONS
        Route::get('/notifications', [\App\Http\Controllers\PIC\NotificationController::class, 'index'])
            ->name('notifications.index');

        Route::post('/notifications/{id}/read', [\App\Http\Controllers\PIC\NotificationController::class, 'markAsRead'])
            ->name('notifications.read');

        Route::post('/notifications/read-all', [\App\Http\Controllers\PIC\NotificationController::class, 'markAllRead'])
            ->name('notifications.readAll');
    });

/*
|--------------------------------------------------------------------------
| SUPERVISOR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:supervisor'])
    ->prefix('supervisor')
    ->name('supervisor.')
    ->group(function () {

        Route::get('/', [SupervisorDashboardController::class, 'index'])
            ->name('dashboard');

        // PROFILE
        Route::get('/profile', [SupervisorProfileController::class, 'index'])
            ->name('profile');

        Route::put('/profile', [SupervisorProfileController::class, 'update'])
            ->name('profile.update');

        Route::put('/profile/password', [SupervisorProfileController::class, 'changePassword'])
            ->name('profile.password');

        Route::get('/profile/login-activity', [SupervisorProfileController::class, 'loginActivity'])
            ->name('profile.loginActivity');

        Route::post('/profile/2fa', [SupervisorProfileController::class, 'toggle2FA'])
            ->name('profile.2fa');

        Route::get('/form-builder', [FormBuilderController::class, 'index'])
            ->name('form-builder.index');

        Route::post('/form-builder', [FormBuilderController::class, 'store'])
            ->name('form-builder.store');

        Route::get('/monitoring', [MonitoringController::class, 'index'])
            ->name('monitoring');

        Route::get('/monitoring/{task}', [MonitoringController::class, 'show'])
            ->name('monitoring.show');

        Route::post('/monitoring/{id}/comment', [MonitoringController::class, 'storeComment'])
            ->name('monitoring.comment');

        Route::post('/monitoring/{task}/revision', [MonitoringController::class, 'revision'])
            ->name('monitoring.revision');

        Route::post('/tasks/{task}/update-status', [MonitoringController::class, 'updateStatus'])
            ->name('tasks.updateStatus');

        Route::get('/reports', [SupervisorReportController::class, 'index'])
            ->name('reports');

        Route::get('/daily-reports', [SupervisorDailyReportController::class, 'index'])
            ->name('daily-reports.index');

        Route::get('/daily-reports/{dailyReport}', [SupervisorDailyReportController::class, 'show'])
            ->name('daily-reports.show');

        // USER MANAGEMENT
        Route::get('/users/create', [UserController::class, 'create'])
            ->name('users.create'); // NAMA ROUTE: supervisor.users.create

        Route::post('/users', [UserController::class, 'store'])
            ->name('users.store'); // NAMA ROUTE: supervisor.users.store

        Route::put('/users/{user}', [UserController::class, 'update'])
            ->name('users.update');

        Route::delete('/users/{user}', [UserController::class, 'destroy'])
            ->name('users.destroy');

        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggle');

        // TASK MANAGEMENT
        Route::get('/tasks', [SupervisorTaskController::class, 'index'])
            ->name('tasks.index');

        Route::get('/tasks/create', [SupervisorTaskController::class, 'create'])
            ->name('tasks.create');

        Route::post('/tasks', [SupervisorTaskController::class, 'store'])
            ->name('tasks.store');

        Route::get('/tasks/{task}', [SupervisorTaskController::class, 'show'])
            ->name('tasks.show');

        Route::get('/tasks/{task}/edit', [SupervisorTaskController::class, 'edit'])
            ->name('tasks.edit');

        Route::put('/tasks/{task}', [SupervisorTaskController::class, 'update'])
            ->name('tasks.update');

        Route::delete('/tasks/{task}', [SupervisorTaskController::class, 'destroy'])
            ->name('tasks.destroy');

        Route::get('/tasks/{task}/review', [SupervisorTaskController::class, 'reviewSubmissions'])
            ->name('tasks.review');

        Route::post('/submissions/{submission}/approve', [SupervisorTaskController::class, 'approveSubmission'])
            ->name('submissions.approve');

        Route::post('/submissions/{submission}/reject', [SupervisorTaskController::class, 'rejectSubmission'])
            ->name('submissions.reject');

        // NOTIFICATIONS
        Route::get('/notifications', [\App\Http\Controllers\Supervisor\NotificationController::class, 'index'])
            ->name('notifications.index');

        Route::post('/notifications/{id}/read', [\App\Http\Controllers\Supervisor\NotificationController::class, 'markAsRead'])
            ->name('notifications.read');

        Route::post('/notifications/read-all', [\App\Http\Controllers\Supervisor\NotificationController::class, 'markAllRead'])
            ->name('notifications.readAll');
    });


/*
|--------------------------------------------------------------------------
| SUPERADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        Route::get('/', [SuperadminDashboardController::class, 'index'])
            ->name('dashboard');

        // NOTIFICATIONS
        Route::get('/notifications', [\App\Http\Controllers\Superadmin\NotificationController::class, 'index'])
            ->name('notifications.index');

        Route::post('/notifications', [\App\Http\Controllers\Superadmin\NotificationController::class, 'store'])
            ->name('notifications.store');

        Route::post('/notifications/{id}/read', [\App\Http\Controllers\Superadmin\NotificationController::class, 'markAsRead'])
            ->name('notifications.read');

        Route::post('/notifications/read-all', [\App\Http\Controllers\Superadmin\NotificationController::class, 'markAllRead'])
            ->name('notifications.readAll');

        // PROFILE
        Route::get('/profile', [SuperadminProfileController::class, 'index'])
            ->name('profile');

        Route::put('/profile', [SuperadminProfileController::class, 'update'])
            ->name('profile.update');

        Route::put('/profile/password', [SuperadminProfileController::class, 'changePassword'])
            ->name('profile.password');

        Route::get('/profile/login-activity', [SuperadminProfileController::class, 'loginActivity'])
            ->name('profile.loginActivity');

        Route::post('/profile/2fa', [SuperadminProfileController::class, 'toggle2FA'])
            ->name('profile.2fa');

        Route::resource('users', SuperadminUserController::class);
        
        // Additional user routes
        Route::post('/users/{user}/reset-password', [SuperadminUserController::class, 'resetPassword'])
            ->name('users.reset-password');
        
        Route::patch('/users/{user}/toggle-status', [SuperadminUserController::class, 'toggleStatus'])
            ->name('users.toggle-status');
        
        Route::resource('divisions', DivisionController::class);

        Route::get('/monitoring', [SuperadminMonitoringController::class, 'index'])
            ->name('monitoring');

        Route::get('/audit', [\App\Http\Controllers\Superadmin\AuditController::class, 'index'])
            ->name('audit');
    });
