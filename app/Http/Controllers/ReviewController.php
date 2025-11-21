<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rating'     => 'required|integer|min:1|max:5',
            'noidung'    => 'nullable|string|max:1000',
            'id_mon'     => 'required|integer',
            'id_donhang' => 'required|integer',
        ]);

        // Lấy khách hàng từ user login
        $userId = Auth::id();
        $kh = DB::table('KhachHang')->where('ID_User', $userId)->first();

        if (!$kh) {
            return back()->with('error', 'Không tìm thấy thông tin khách hàng!');
        }

        // Kiểm tra món thuộc đơn hàng đó có phải của khách không
        $isOwned = DB::table('DonHang')
            ->where('ID_DonHang', $request->id_donhang)
            ->where('ID_KhachHang', $kh->ID_KhachHang)
            ->exists();

        if (!$isOwned) {
            return back()->with('error', 'Bạn không thể đánh giá đơn hàng này!');
        }

        // Kiểm tra đã đánh giá chưa
        $exists = Review::where('ID_Mon', $request->id_mon)
                        ->where('ID_DonHang', $request->id_donhang)
                        ->where('ID_KhachHang', $kh->ID_KhachHang)
                        ->exists();

        if ($exists) {
            return back()->with('error', 'Bạn đã đánh giá món này rồi!');
        }

        // Tạo đánh giá mới
        Review::create([
            'ID_KhachHang' => $kh->ID_KhachHang,
            'ID_Mon'       => $request->id_mon,
            'ID_DonHang'   => $request->id_donhang,
            'Rating'       => $request->rating,
            'NoiDung'      => $request->noidung,
        ]);

        return back()->with('success', 'Đánh giá thành công!');
    }
}
