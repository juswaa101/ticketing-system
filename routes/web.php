<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\TicketLogsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\TicketController as UserTicketController;
use App\Http\Controllers\User\TicketLogsController as UserTicketLogsController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\User\DepartmentController;
use App\Http\Controllers\User\TicketCategoryController;
use App\Http\Controllers\VerifyUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Landing Page
Route::view('/', 'welcome')->name('landing-page');

// Guest Access
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.auth');
    Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.auth');
});

// User Access
Route::group(['middleware' => ['auth', 'can:user', 'user_verified']], function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    Route::get('/fetch-user-tickets', [UserTicketController::class, 'fetchTickets'])->name('fetch.user.tickets');
    Route::get('/fetch-user-categories', [TicketCategoryController::class, 'index'])->name('fetch.user.categories');
    Route::get('/fetch-user-roles', [DepartmentController::class, 'index'])->name('fetch.user.roles');


    Route::resource('user-tickets', UserTicketController::class);
    Route::get('/user-logs', [UserTicketLogsController::class, 'index'])->name('logs.user.index');
    Route::get('/user-render-logs', [UserTicketLogsController::class, 'renderLogs'])->name('logs.user');
});

// Admin Access
Route::group(['middleware' => ['auth', 'can:admin', 'user_verified']], function () {
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/fetch-tickets', [AdminTicketController::class, 'fetchTickets'])->name('fetch.tickets');
    Route::resource('admin-tickets', AdminTicketController::class);

    Route::get('/fetch-users', [UserController::class, 'users']);
    Route::resource('users', UserController::class);

    Route::get('/fetch-roles', [RoleController::class, 'roles']);
    Route::resource('roles', RoleController::class);

    Route::get('/fetch-categories', [CategoryController::class, 'fetchCategory'])->name('fetch.categories');
    Route::resource('categories', CategoryController::class);

    Route::get('/logs', [TicketLogsController::class, 'index'])->name('logs.index');
    Route::get('/admin-render-logs', [TicketLogsController::class, 'renderLogs'])->name('logs.admin');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/verification', [VerifyUserController::class, 'index'])->name('verify');
    Route::get('/verify-email/{user}', [VerifyUserController::class, 'verifyUser'])->name('verify.email');
    Route::post('/resend-verification', [VerifyUserController::class, 'sendVerification'])->name('resend.verify');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.view');
    Route::get('/account-settings', [SettingsController::class, 'index'])->name('settings.view');
    Route::put('/account-settings', [SettingsController::class, 'updateProfile'])->name('settings.update');

    Route::resource('comments', CommentController::class);
    Route::get('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
