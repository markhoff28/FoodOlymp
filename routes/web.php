<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminProfilController;
use App\Http\Controllers\Admin\AdminRestPasswordController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Admin Group Middleware 
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    // Admin manage profile data
    Route::get('/admin/profile', [AdminProfilController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminProfilController::class, 'AdminProfileStore'])->name('admin.profile.store');
});
// End Admin Group Middleware 

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
Route::post('/admin/login_submit', [AdminController::class, 'AdminLoginSubmit'])->name('admin.login_submit');

// Admin forget password
Route::get('/admin/forget-password', [AdminRestPasswordController::class, 'AdminForgetPassword'])->name('admin.forget-password');
Route::post('/admin/password-submit', [AdminRestPasswordController::class, 'AdminPasswordSubmit'])->name('admin.password-submit');
Route::get('/admin/reset-password/{token}/{email}', [AdminRestPasswordController::class, 'AdminResetPassword']);
Route::post('/admin/reset_password_submit', [AdminRestPasswordController::class, 'AdminResetPasswordSubmit'])->name('admin.reset_password_submit');
