<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Lấy khách bằng ID_User (chuẩn nhất)
    $kh = DB::table('khachhang')->where('ID_User', $user->id)->first();

    if (!$kh) {
        return view('frontend.history', ['orders' => collect([])]);
    }

    // Đơn hàng
    $orders = DB::table('donhang')
        ->where('ID_KhachHang', $kh->ID_KhachHang)
        ->orderBy('ThoiGian', 'desc')
        ->get();

   foreach ($orders as $od) {

    $details = DB::table('chitietdonhang')
        ->join('mon', 'mon.ID_Mon', '=', 'chitietdonhang.ID_Mon')
        ->where('chitietdonhang.ID_DonHang', $od->ID_DonHang)
        ->select(
            'chitietdonhang.ID_ChiTiet',
            'chitietdonhang.ID_Mon',
            'mon.TenMon',
            'chitietdonhang.SoLuong',
            'chitietdonhang.GiaBan',
            'chitietdonhang.ThanhTien',
            'chitietdonhang.TuyChon_JSON'
        )
        ->get();

    // ========= THÊM REVIEW CHECK =========
    foreach ($details as $ct) {
        $ct->reviewed = DB::table('reviews')
            ->where('ID_KhachHang', $kh->ID_KhachHang)
            ->where('ID_Mon', $ct->ID_Mon)
            ->where('ID_DonHang', $od->ID_DonHang)
            ->exists();
    }
    // ======================================

    $od->details = $details;
}

    return view('frontend.history', compact('orders'));
}

}
