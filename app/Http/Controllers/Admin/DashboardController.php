<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mon;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $soMon = Mon::count();
        $soDon = DonHang::count();

        $tongDoanhThu = DonHang::daThanhToan()->sum('TongTien');

        $doanhThuHomNay = DonHang::daThanhToan()
            ->whereDate('ThoiGian', today())
            ->sum('TongTien');

        // Doanh thu 7 ngày gần nhất
        $raw7 = DonHang::daThanhToan()
            ->whereDate('ThoiGian', '>=', today()->subDays(6))
            ->selectRaw('DATE(ThoiGian) as ngay, SUM(TongTien) as tong')
            ->groupBy('ngay')
            ->orderBy('ngay')
            ->get();

        $labels7 = [];
        $data7   = [];

        for ($i = 6; $i >= 0; $i--) {
            $d = today()->subDays($i)->format('Y-m-d');
            $labels7[] = today()->subDays($i)->format('d/m');

            $row = $raw7->firstWhere('ngay', $d);
            $data7[] = $row ? (float)$row->tong : 0;
        }

        // Top 5 món bán chạy
        $topMons = ChiTietDonHang::select('ID_Mon', DB::raw('SUM(SoLuong) as tong_sl'))
            ->groupBy('ID_Mon')
            ->orderByDesc('tong_sl')
            ->with('mon')
            ->limit(5)
            ->get();

        // Đơn hàng gần đây
        $donGanDay = DonHang::with(['khachHang', 'ban'])
            ->orderByDesc('ThoiGian')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'soMon'            => $soMon,
            'soDon'            => $soDon,
            'tongDoanhThu'     => $tongDoanhThu,
            'doanhThuHomNay'   => $doanhThuHomNay,
            'labels7'          => $labels7,
            'data7'            => $data7,
            'topMons'          => $topMons,
            'donGanDay'        => $donGanDay,
        ]);
    }
}
