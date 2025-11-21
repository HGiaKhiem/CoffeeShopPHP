<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mon;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login');
        }

        if (! isset($user->role) || $user->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập khu vực này.');
        }

        // Tổng số món
        $soMon = Mon::count();

        // Tổng số đơn
        $soDon = DonHang::count();

        // Doanh thu tất cả (dùng trường TongTien của DonHang)
        $tongDoanhThu = DonHang::sum('TongTien');

        // Doanh thu hôm nay
        $doanhThuHomNay = DonHang::whereDate('ThoiGian', Carbon::today())->sum('TongTien');

        // Top 5 món bán chạy (ID_Mon + tong_sl + TenMon)
        $topMonsRaw = DB::table('ChiTietDonHang as c')
            ->select('c.ID_Mon', DB::raw('SUM(c.SoLuong) as tong_sl'), 'm.TenMon')
            ->join('Mon as m', 'm.ID_Mon', '=', 'c.ID_Mon')
            ->groupBy('c.ID_Mon', 'm.TenMon')
            ->orderByDesc('tong_sl')
            ->limit(5)
            ->get();

        // map to objects with ->mon property to match view expectations
        $topMons = $topMonsRaw->map(function ($r) {
            return (object) [
                'tong_sl' => $r->tong_sl,
                'mon' => (object) ['TenMon' => $r->TenMon],
            ];
        });

        // Doanh thu 7 ngày gần nhất (labels + data)
        $labels7 = [];
        $data7 = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $labels7[] = $day->format('d/m');
            $data7[] = (float) DonHang::whereDate('ThoiGian', $day)->sum('TongTien');
        }

        // Đơn hàng gần đây (5)
        $donGanDay = DonHang::with(['khachHang', 'ban'])->orderBy('ThoiGian', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact(
            'soMon', 'soDon', 'tongDoanhThu', 'doanhThuHomNay',
            'topMons', 'labels7', 'data7', 'donGanDay'
        ));
    }
}
