<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AdminController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// Admin
Route::get('admin/login', [AdminController::class, 'login'])->middleware('honeypot')->name('admin_login');

Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin_dashboard');
});

Route::prefix('admin')->group(function () {
    //    Route::get('/login', [AdminController::class, 'login'])->name('admin_login');
    Route::post('/login-submit', [AdminController::class, 'login_submit'])->middleware('honeypot')->name('admin_login_submit');
    //    Route::post('/login-submit', [AdminController::class, 'login_submit'])->name('admin_login_submit');
    Route::get('/logout', [AdminController::class, 'admin_logout'])->name('admin_logout');
    Route::get('/forgot-password', [AdminController::class, 'forgot_password'])->name('admin_forgot_password');
    Route::post('/forgot-password', [AdminController::class, 'forgot_password_submit'])->middleware('honeypot')->name('admin_forgot_password_submit');
    Route::post('/forgot-password', [AdminController::class, 'forgot_password_submit'])->name('admin_forgot_password_submit');
    Route::get('/password-reset/{token}/{email}', [AdminController::class, 'admin_reset_password'])->middleware('honeypot');
    Route::post('/password-reset/{token}/{email}', [AdminController::class, 'admin_reset_password_submit'])->middleware('honeypot')->name('reset_password_submit');
    //    Route::post('/password-reset/{token}/{email}', [AdminController::class, 'admin_reset_password_submit'])->name('reset_password_submit');
});

require __DIR__.'/auth.php';
