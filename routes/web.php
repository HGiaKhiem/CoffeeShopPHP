<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\MonController;
use App\Http\Controllers\Admin\LoaiMonController;
use App\Http\Controllers\Admin\DonHangController;
use App\Http\Controllers\Admin\KhachHangController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Mặc định trang chủ / và dashboard đều hiển thị home.blade.php
| Các route khác như /menu, /profile, /login, /register vẫn hoạt động bình thường.
|
*/

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route login/register mặc định của Laravel Breeze / auth routes
require __DIR__.'/auth.php';

// Các route yêu cầu đăng nhập
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========== ADMIN ==========
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Loại món
        Route::resource('loai-mon', LoaiMonController::class)->names('loaimon');

        // Món
        Route::resource('mon', MonController::class);

        // Khách hàng
        Route::get('/khach-hang', [KhachHangController::class, 'index'])->name('khachhang.index');
        Route::get('/khach-hang/{id}', [KhachHangController::class, 'show'])->name('khachhang.show');

        // Đơn hàng
        Route::get('/don-hang', [DonHangController::class, 'index'])->name('donhang.index');
        Route::get('/don-hang/{id}', [DonHangController::class, 'show'])->name('donhang.show');
    });

// ==== FAKE LOGIN CHỈ DÙNG ĐỂ TEST, SAU NÀY NHỚ XÓA ====
Route::get('/fake-login-admin', function () {
    Auth::loginUsingId(1); // chỉnh lại id nếu admin của bạn không phải 1
    return redirect()->route('admin.dashboard');
});

Route::get('/fake-login-cashier', function () {
    Auth::loginUsingId(2); // chỉnh lại id nếu cashier của bạn không phải 2
    return redirect()->route('admin.dashboard');
});