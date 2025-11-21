<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KhachHang;
use Illuminate\Support\Facades\DB;

class KhachHangController extends Controller
{
    public function index()
    {
        // lấy khách + số đơn + tổng tiền
        $khachs = KhachHang::withCount('donHangs')
            ->withSum('donHangs as tong_tien', 'TongTien')
            ->orderBy('ID_KhachHang', 'asc')

            ->paginate(10);

        return view('admin.khachhang.index', compact('khachs'));
    }

    public function show($id)
    {
        $kh = KhachHang::with(['donHangs' => function($q){
                $q->orderByDesc('ThoiGian');
            }])
            ->withCount('donHangs')
            ->withSum('donHangs as tong_tien', 'TongTien')
            ->findOrFail($id);

        return view('admin.khachhang.show', compact('kh'));
    }
}
