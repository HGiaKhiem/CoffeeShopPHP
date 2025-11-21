<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ReviewController;

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

Route::get('/ajax/menu', [MenuController::class, 'ajaxMenu'])->name('menu.ajax');

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




// routes/lich sư mua hàng
Route::get('/history', [HistoryController::class, 'index'])->name('history');
//routes danh gia
Route::post('/review/store', [ReviewController::class, 'store'])
     ->name('review.store')
     ->middleware('auth');


// Route đăng nhập, đăng ký, quên mật khẩu, logout
require __DIR__.'/auth.php';
