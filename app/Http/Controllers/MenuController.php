<?php

namespace App\Http\Controllers;

use App\Models\Mon;
use App\Models\Size;
use App\Models\Topping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        // Danh sách món phân trang mặc định
        $mons = Mon::with('loaiMon')->paginate(12);

        // Toàn bộ loại món để render filter
        $loaiMons = Mon::with('loaiMon')
            ->get()
            ->pluck('loaiMon.TenLoaiMon')
            ->unique()
            ->filter();

        return view('frontend.menu', compact('mons', 'loaiMons'));
    }

    public function ajaxMenu(Request $request)
    {
        $search = $request->search;
        $filter = $request->filter;

        $query = Mon::with('loaiMon');

        // Lọc theo loại (data-filter là slug của TenLoaiMon)
        if ($filter && $filter !== 'all') {
            $query->whereHas('loaiMon', function ($q) use ($filter) {
                $q->whereRaw('LOWER(REPLACE(TenLoaiMon, " ", "-")) = ?', [$filter]);
            });
        }

        // Tìm kiếm theo tên món
        if (!empty($search)) {
            $query->where('TenMon', 'LIKE', "%$search%");
        }

        // Phân trang
        $mons = $query->paginate(12);

        // Render phần HTML danh sách + phân trang
        $html = view('frontend.partials.menu-ajax', compact('mons'))->render();

        return response()->json([
            'html' => $html,
        ]);
    }

   public function show($id)
{
    // Lấy món + loại món
    $mon = Mon::with('loaiMon')->findOrFail($id);

    // Load size + topping
    $sizes = Size::all();
    $toppings = Topping::all();

    // Load đánh giá của món
    $reviews = DB::table('reviews')
        ->join('khachhang', 'khachhang.ID_KhachHang', '=', 'reviews.ID_KhachHang')
        ->where('reviews.ID_Mon', $id)
        ->select(
            'reviews.Rating',
            'reviews.NoiDung',
            'reviews.NgayTao',
            'khachhang.TenKH'
        )
        ->orderBy('reviews.NgayTao', 'desc')
        ->get();

    return view('frontend.menu-detail', compact('mon', 'sizes', 'toppings', 'reviews'));
}

}
