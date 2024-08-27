<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset']);

// Protected Routes (only for authenticated users)
Route::group(['middleware' => 'auth'], function () {

    // User Profile Management
    Route::get('profile', [UserController::class, 'show'])->name('user.profile');
    Route::post('profile/update', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    Route::post('profile/change-password', [UserController::class, 'changePassword'])->name('user.changePassword');

    // Admin Routes (only for users with the Admin role)
    Route::group(['middleware' => 'role:Admin'], function () {

        // User Management
        Route::get('users', [UserController::class, 'index'])->name('user.index');
        Route::get('users/{id}', [UserController::class, 'showUser'])->name('user.show');
        Route::post('users', [UserController::class, 'store'])->name('user.store');
        Route::put('users/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('users/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::post('users/{id}/assign-role', [UserController::class, 'assignRole'])->name('user.assignRole');

        // Activity Logs
        Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    });

});
// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);

// Route::group(['middleware' => ['auth', 'role:Admin']], function () {
//     Route::get('/users', [UserController::class, 'index']);
//     Route::post('/users', [UserController::class, 'store']);
//     Route::put('/users/{id}', [UserController::class, 'update']);
//     Route::delete('/users/{id}', [UserController::class, 'destroy']);
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
