<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminProfilController;
use App\Http\Controllers\Admin\AdminRestPasswordController;
use App\Http\Controllers\Admin\AdminChangePasswordController;

use App\Http\Controllers\Backend\CategoryController;

use App\Http\Controllers\Client\ClientProfilController;
use App\Http\Controllers\Client\ClientChangePasswordController;

use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\User\UserChangePasswordController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;

Route::get('/', [IndexController::class, 'Index'])->name('index');

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/dashboard', function () {
    return view('frontend.dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/profile/store', [UserController::class, 'ProfileStore'])->name('profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    // Usee update password
    Route::get('/change/password', [UserChangePasswordController::class, 'ChangePassword'])->name('change.password');
    Route::post('/user/password/update', [UserChangePasswordController::class, 'UserPasswordUpdate'])->name('user.password.update');
});

require __DIR__ . '/auth.php';

// Admin Group Middleware 
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    // Admin manage profile data
    Route::get('/admin/profile', [AdminProfilController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminProfilController::class, 'AdminProfileStore'])->name('admin.profile.store');
    // Admin update password
    Route::get('/admin/change/password', [AdminChangePasswordController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminChangePasswordController::class, 'AdminPasswordUpdate'])->name('admin.password.update');

    // Category All Route 
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/all/category', 'AllCategory')->name('all.category');
        Route::get('/add/category', 'AddCategory')->name('add.category');
        Route::post('/store/category', 'StoreCategory')->name('store.category');
        Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
        Route::post('/update/category', 'UpdateCategory')->name('update.category');
    });
});
// End Admin Group Middleware 

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
Route::post('/admin/login_submit', [AdminController::class, 'AdminLoginSubmit'])->name('admin.login_submit');

// Admin forget password
Route::get('/admin/forget-password', [AdminRestPasswordController::class, 'AdminForgetPassword'])->name('admin.forget-password');
Route::post('/admin/password-submit', [AdminRestPasswordController::class, 'AdminPasswordSubmit'])->name('admin.password-submit');
Route::get('/admin/reset-password/{token}/{email}', [AdminRestPasswordController::class, 'AdminResetPassword']);
Route::post('/admin/reset_password_submit', [AdminRestPasswordController::class, 'AdminResetPasswordSubmit'])->name('admin.reset_password_submit');

// Client Group Group Middleware
Route::middleware('client')->group(function () {
    Route::get('/client/dashboard', [ClientController::class, 'ClientDashboard'])->name('client.dashboard');
    Route::get('/client/logout', [ClientController::class, 'ClientLogout'])->name('client.logout');
    // Client manage profile data
    Route::get('/client/profile', [ClientProfilController::class, 'ClientProfile'])->name('client.profile');
    Route::post('/client/profile/store', [ClientProfilController::class, 'ClientProfileStore'])->name('client.profile.store');
    // Client update password
    Route::get('/client/change/password', [ClientChangePasswordController::class, 'ClientChangePassword'])->name('client.change.password');
    Route::post('/client/password/update', [ClientChangePasswordController::class, 'ClientPasswordUpdate'])->name('client.password.update');
});
// End Client Group Group Middleware

Route::get('/client/login', [ClientController::class, 'ClientLogin'])->name('client.login');
Route::get('/client/register', [ClientController::class, 'ClientRegister'])->name('client.register');
Route::post('/client/register/submit', [ClientController::class, 'ClientRegisterSubmit'])->name('client.register.submit');
Route::post('/client/login_submit', [ClientController::class, 'ClientLoginSubmit'])->name('client.login_submit');
