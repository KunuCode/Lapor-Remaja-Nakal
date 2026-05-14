<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\LaporController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\LaporanController as DashboardLaporanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CamatController;
use App\Http\Controllers\Admin\ProfilController as AdminProfilController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\NotifikasiController;  // ← TAMBAH INI

/*
|--------------------------------------------------------------------------
| Halaman Publik
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');

/*
|--------------------------------------------------------------------------
| Autentikasi
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Lapor (Auth Required)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/lapor', [LaporController::class, 'index'])->name('lapor');
    Route::post('/lapor', [LaporController::class, 'store'])->name('lapor.store');
});

/*
|--------------------------------------------------------------------------
| Dashboard Masyarakat (Auth + Masyarakat Middleware)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', \App\Http\Middleware\MasyarakatMiddleware::class])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/laporan', [DashboardLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{id}', [DashboardLaporanController::class, 'show'])->name('laporan.show');
});

/*
|--------------------------------------------------------------------------
| Admin Panel (Auth + Admin Middleware)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Slider
    Route::get('/slider', [SliderController::class, 'index'])->name('slider.index');
    Route::post('/slider', [SliderController::class, 'store'])->name('slider.store');
    Route::put('/slider/{id}', [SliderController::class, 'update'])->name('slider.update');
    Route::delete('/slider/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');
    Route::post('/slider/{id}/toggle', [SliderController::class, 'toggleActive'])->name('slider.toggle');

    // Camat
    Route::get('/camat', [CamatController::class, 'index'])->name('camat.index');
    Route::post('/camat', [CamatController::class, 'store'])->name('camat.store');
    Route::put('/camat/{id}', [CamatController::class, 'update'])->name('camat.update');
    Route::delete('/camat/{id}', [CamatController::class, 'destroy'])->name('camat.destroy');

    // Profil
    Route::get('/profil', [AdminProfilController::class, 'index'])->name('profil.index');
    Route::post('/profil/update', [AdminProfilController::class, 'update'])->name('profil.update');

    // Berita
    Route::get('/berita', [AdminBeritaController::class, 'index'])->name('berita.index');
    Route::post('/berita', [AdminBeritaController::class, 'store'])->name('berita.store');
    Route::put('/berita/{id}', [AdminBeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{id}', [AdminBeritaController::class, 'destroy'])->name('berita.destroy');
    Route::delete('/berita/image/{id}', [AdminBeritaController::class, 'deleteImage'])->name('berita.deleteImage');

    // Laporan
    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{id}', [AdminLaporanController::class, 'show'])->name('laporan.show');
    Route::put('/laporan/{id}/status', [AdminLaporanController::class, 'updateStatus'])->name('laporan.updateStatus');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/logo', [SettingController::class, 'updateLogo'])->name('settings.updateLogo');
    Route::post('/settings/favicon', [SettingController::class, 'updateFavicon'])->name('settings.updateFavicon');
    Route::post('/settings/site-name', [SettingController::class, 'updateSiteName'])->name('settings.updateSiteName');

    // ==================== NOTIFIKASI ====================  ← TAMBAH BLOK INI
    Route::get('/notifikasi/count', [NotifikasiController::class, 'count'])->name('notifikasi.count');
    Route::get('/notifikasi/latest', [NotifikasiController::class, 'latest'])->name('notifikasi.latest');
    Route::post('/notifikasi/mark-read/{id}', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.markRead');
    Route::post('/notifikasi/mark-all-read', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.markAllRead');
});