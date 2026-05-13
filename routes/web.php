<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect('/login');
    });

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/signup', [AuthController::class, 'showForm']);
    Route::post('/signup', [AuthController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/admin-logout', [AdminAuthController::class, 'adminLogout']);

});

    Route::get('admin', function () {
        return redirect('admin/login');
    });
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin']);
    Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::middleware(['auth','admin'])->group(function () {
    Route::get('/admin/dashboard', [EmployeeController::class, 'index'])->middleware(['auth','admin']);
    Route::get('/admin/employee/{id}', [EmployeeController::class, 'show'])->middleware(['auth','admin']);
    Route::post('/log-out', [AdminAuthController::class, 'logout'])->middleware(['auth','admin']);
});

