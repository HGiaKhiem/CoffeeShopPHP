<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
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

// Dashboard — sau khi đăng nhập sẽ quay về home
Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Trang menu
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

// Trang chi tiết món 
Route::get('/menu/{id}', [MenuController::class, 'show'])
    ->name('menu.show');

// Các route yêu cầu đăng nhập
Route::middleware('auth')->group(function () {

    // Trang chỉnh sửa profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/update-qty', [CartController::class, 'updateQuantity'])
    ->name('cart.update.qty');
Route::post('/cart/delete-item', [CartController::class, 'deleteItem'])
    ->name('cart.delete.item');
Route::get('/cart/order', [CartController::class, 'order'])->name('cart.order');
Route::get('/cart/pay', [CartController::class, 'pay'])->name('cart.pay');

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