<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Mặc định trang chủ / và dashboard đều hiển thị home.blade.php
| Các route khác như /menu, /profile, /login, /register vẫn hoạt động bình thường.
|
*/

// ✅ Trang chủ Coffee Shop
Route::get('/', [HomeController::class, 'index'])->name('home');

// ✅ Sau khi đăng nhập, Laravel chuyển về /dashboard — cũng hiển thị trang home.blade.php
Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ✅ Trang menu (nếu bạn có controller)
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

// ✅ Các route yêu cầu đăng nhập
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Các route đăng nhập / đăng ký
require __DIR__.'/auth.php';
