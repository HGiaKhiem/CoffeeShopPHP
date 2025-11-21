<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mon;
use App\Models\Size;
use App\Models\Topping;
use Illuminate\Support\Facades\Auth;

$userId = Auth::id();  // Lấy ID user đã đăng nhập


use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('frontend.cart', compact('cart'));
    }


    public function add(Request $request, $id)
    {
        $mon = Mon::findOrFail($id);
        $qty = max(1, (int)$request->quantity);

        // ----- SIZE -----
        $size = Size::find($request->size);
        $sizeName  = $size->TenSize ?? 'Mặc định';
        $sizeExtra = $size->GiaTang ?? 0;

        // ----- TOPPING -----
        $toppingIds = $request->toppings ?? [];
        sort($toppingIds); // tránh khác thứ tự

        $toppings = Topping::whereIn('ID_Topping', $toppingIds)->get();
        $toppingNames = $toppings->pluck('TenTopping')->toArray();
        $toppingExtra = $toppings->sum('GiaTang');

        // ----- GIÁ -----
        $finalPrice = floatval($mon->Gia) + floatval($sizeExtra) + floatval($toppingExtra);

        // ----- CART -----
        $cart = session()->get('cart', []);

        $uniqueKey = "{$id}-{$request->size}-" . implode('_', $toppingIds);

        if (isset($cart[$uniqueKey])) {
            $cart[$uniqueKey]['quantity'] += $qty;
        } else {
            $cart[$uniqueKey] = [
                'id'            => $mon->ID_Mon,
                'name'          => $mon->TenMon,
                'image'         => $mon->HinhAnh ?? null, // hoặc generate slug

                'size'          => $sizeName,
                'size_price'    => $sizeExtra,

                'toppings'      => $toppingNames,
                'topping_price' => $toppingExtra,

                'base_price'    => $mon->Gia,
                'price'         => $finalPrice,
                'quantity'      => $qty,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Đã thêm vào giỏ hàng!');
    }


    public function remove($key)
    {
        $cart = session()->get('cart', []);
        unset($cart[$key]);
        session()->put('cart', $cart);

        return back()->with('success', 'Đã xóa món!');
    }


    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Giỏ hàng đã trống!');
    }


    // ----- AJAX update quantity -----
    public function updateQuantity(Request $request)
    {
        $key = $request->key;
        $quantity = max(1, (int)$request->quantity);

        $cart = session('cart', []);

        if (!isset($cart[$key])) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        $cart[$key]['quantity'] = $quantity;
        session()->put('cart', $cart);

        $lineTotal = $cart[$key]['price'] * $quantity;
        $grandTotal = collect($cart)->sum(function ($i) {
            return $i['price'] * $i['quantity'];
        });

        return response()->json([
            'success'     => true,
            'line_total'  => number_format($lineTotal),
            'grand_total' => number_format($grandTotal)
        ]);
    }


    // ----- AJAX delete -----
    public function deleteItem(Request $request)
    {
        $key = $request->key;

        $cart = session('cart', []);

        if (!isset($cart[$key])) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        unset($cart[$key]);
        session()->put('cart', $cart);

        $grandTotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        return response()->json([
            'success'      => true,
            'grand_total'  => number_format($grandTotal),
            'cart_empty'   => count($cart) == 0
        ]);
    }


 public function order()
{
    $cart = session('cart', []);
    if (empty($cart)) {
        return back()->with('error', 'Giỏ hàng trống!');
    }

    // Lấy khách hàng theo tài khoản đăng nhập
    $userId = Auth::id(); 
    $kh = DB::table('KhachHang')->where('ID_User', $userId)->first();

    if (!$kh) {
        return back()->with('error', 'Không tìm thấy thông tin khách hàng!');
    }

    $idKhach = $kh->ID_KhachHang;
    $idBan = session('id_ban', 1);

    // Tạo đơn
    $idDon = DB::table('DonHang')->insertGetId([
        'ID_KhachHang' => $idKhach,
        'ID_Ban'       => $idBan,
        'TrangThai'    => 'CHUA_THANH_TOAN',
        'TongTien'     => 0,
    ]);

    $tongCong = 0;

    foreach ($cart as $item) {
        $thanhTien = $item['price'] * $item['quantity'];

        DB::table('ChiTietDonHang')->insert([
            'ID_DonHang'   => $idDon,
            'ID_Mon'       => $item['id'],
            'SoLuong'      => $item['quantity'],
            'GiaBan'       => $item['price'],
            'TuyChon_JSON' => json_encode([
                'size' => $item['size'],
                'toppings' => $item['toppings'],
                'extraSize' => $item['size_price'],
                'extraTop' => $item['topping_price'],
            ], JSON_UNESCAPED_UNICODE),
            'ThanhTien'    => $thanhTien,
        ]);

        $tongCong += $thanhTien;
    }

    DB::table('DonHang')->where('ID_DonHang', $idDon)->update([
        'TongTien' => $tongCong,
    ]);

    return back()->with('success', "Đặt hàng thành công! Mã đơn: DH{$idDon}");
}


    public function pay()
    {
        // Lấy đơn hàng chưa thanh toán mới nhất
        $don = DB::table('DonHang')
            ->where('TrangThai', 'CHUA_THANH_TOAN')
            ->orderByDesc('ID_DonHang')
            ->first();

        if (!$don) {
            return back()->with('error', 'Không có đơn hàng nào để thanh toán!');
        }

        // Cập nhật trạng thái đơn
        DB::table('DonHang')
            ->where('ID_DonHang', $don->ID_DonHang)
            ->update(['TrangThai' => 'DA_THANH_TOAN']);

        // Xóa giỏ hàng
        session()->forget('cart');

        return redirect()->route('menu')
            ->with('success', "Thanh toán thành công đơn hàng DH{$don->ID_DonHang}!");
    }


}
