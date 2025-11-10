<?php

namespace App\Http\Controllers;

use App\Models\Mon;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // Lấy toàn bộ món + loại món liên kết
        $mons = Mon::with('loaiMon')->get();

        // Truyền dữ liệu qua view
        return view('frontend.partials.menu', compact('mons'));
    }
}
