<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use Illuminate\Http\Request;

class DonHangController extends Controller
{
    public function index(Request $req)
    {
        $st = $req->input('trang_thai'); // CHUA_THANH_TOAN, DA_THANH_TOAN, HUY_DON hoặc null
        $ngay = $req->input('ngay');     // yyyy-mm-dd

        $q = DonHang::with(['khachHang', 'ban'])
            ->orderByDesc('ThoiGian');

        if ($st) {
            $q->where('TrangThai', $st);
        }

        if ($ngay) {
            $q->whereDate('ThoiGian', $ngay);
        }

        $donHangs = $q->paginate(10);

        return view('admin.donhang.index', compact('donHangs', 'st', 'ngay'));
    }

    public function show($id)
    {
        $donHang = DonHang::with(['khachHang', 'ban', 'chiTiet.mon'])
            ->findOrFail($id);

        return view('admin.donhang.show', compact('donHang'));
    }
}
