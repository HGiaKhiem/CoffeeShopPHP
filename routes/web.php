<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MonController;
use App\Http\Controllers\Admin\LoaiMonController;
use App\Http\Controllers\Admin\DonHangController;
use App\Http\Controllers\Admin\KhachHangController;

// ================== TRANG NGƯỜI DÙNG ==================

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Dashboard — sau khi đăng nhập sẽ quay về home
Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Trang menu
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

// Chi tiết món 
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');

// Các route yêu cầu đăng nhập (profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ================== GIỎ HÀNG ==================
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/update-qty', [CartController::class, 'updateQuantity'])->name('cart.update.qty');
Route::post('/cart/delete-item', [CartController::class, 'deleteItem'])->name('cart.delete.item');
Route::get('/cart/order', [CartController::class, 'order'])->name('cart.order');
Route::get('/cart/pay', [CartController::class, 'pay'])->name('cart.pay');

// Route login/register mặc định của Laravel Breeze
require __DIR__.'/auth.php';


// ================== TRANG ADMIN ==================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Trang dashboard admin
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
