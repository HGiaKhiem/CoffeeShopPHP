<?php

namespace App\Http\Controllers;

use App\Models\Mon;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy 8 món bất kỳ (nếu có bảng Mon)
        $mons = Mon::with('loaiMon')->take(8)->get();

        // ✅ Trả về trang chủ home.blade.php
        return view('home', compact('mons'));
    }
}
