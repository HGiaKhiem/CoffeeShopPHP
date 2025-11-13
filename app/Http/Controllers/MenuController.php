<?php

namespace App\Http\Controllers;

use App\Models\Mon;
use App\Models\Size;
use App\Models\Topping;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // Lấy toàn bộ món + loại
        $mons = Mon::with('loaiMon')->get();

        return view('frontend.menu', compact('mons'));
    }

    public function show($id)
    {
        // Lấy món + loại món
        $mon = Mon::with('loaiMon')->findOrFail($id);

        // Load toàn bộ size và topping
        $sizes = Size::all();
        $toppings = Topping::all();

        return view('frontend.menu-detail', compact('mon', 'sizes', 'toppings'));
    }
}
