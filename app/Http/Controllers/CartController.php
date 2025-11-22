<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mon;
use App\Models\Size;
use App\Models\Topping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // ==========================
    //  HIỂN THỊ GIỎ HÀNG
    // ==========================
    public function index()
    {
        $cart = session('cart', []);
        return view('frontend.cart', compact('cart'));
    }


    // ==========================
    //  THÊM MÓN VÀO GIỎ
    // ==========================
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
        sort($toppingIds);

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
                'image'         => $mon->HinhAnh ?? null,

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


    // ==========================
    //  XÓA 1 MÓN
    // ==========================
    public function remove($key)
    {
        $cart = session()->get('cart', []);
        unset($cart[$key]);
        session()->put('cart', $cart);

        return back()->with('success', 'Đã xóa món!');
    }


    // ==========================
    //  XÓA TOÀN BỘ GIỎ
    // ==========================
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Giỏ hàng đã trống!');
    }


    // ==========================
    //  AJAX UPDATE SỐ LƯỢNG
    // ==========================
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
        $grandTotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        return response()->json([
            'success'     => true,
            'line_total'  => number_format($lineTotal),
            'grand_total' => number_format($grandTotal)
        ]);
    }


    // ==========================
    //  AJAX XÓA ITEM
    // ==========================
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


    // ==========================
    //  ĐI ĐẾN CHECKOUT PAGE
    // ==========================
public function checkout()
{
    $cart = session('cart', []);

    if (empty($cart)) {
        return redirect()->route('cart')->with('error', 'Giỏ hàng trống!');
    }

    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục!');
    }

    $kh = DB::table('KhachHang')
        ->where('ID_User', $user->id)
        ->first();

    return view('frontend.checkout', compact('cart', 'kh', 'user'));
}



    // ==========================
    //  XÁC NHẬN ĐẶT HÀNG
    // ==========================
    public function placeOrder(Request $request)
    {
        $request->validate([
            'SDT_NhanHang' => 'required',
            'DiaChi'       => 'required',
            'PhuongThucThanhToan' => 'required',
            'GhiChu'       => 'nullable'
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng trống!');
        }

        DB::beginTransaction();

        try {
            $userId = Auth::id();
            $kh = DB::table('KhachHang')->where('ID_User', $userId)->first();

            $idDon = DB::table('DonHang')->insertGetId([
                'ID_KhachHang'        => $kh->ID_KhachHang,
                'TrangThai'           => 'CHUA_THANH_TOAN',
                'TongTien'            => 0,
                'DiaChi'              => $request->DiaChi,
                'SDT_NhanHang'        => $request->SDT_NhanHang,
                'PhuongThucThanhToan' => $request->PhuongThucThanhToan,
                'GhiChu'              => $request->GhiChu
            ]);

            $tong = 0;

            foreach ($cart as $item) {
                $line = $item['price'] * $item['quantity'];

                DB::table('ChiTietDonHang')->insert([
                    'ID_DonHang'   => $idDon,
                    'ID_Mon'       => $item['id'],
                    'SoLuong'      => $item['quantity'],
                    'GiaBan'       => $item['price'],
                    'ThanhTien'    => $line,
                    'TuyChon_JSON' => json_encode([
                        'size'     => $item['size'],
                        'toppings' => $item['toppings']
                    ], JSON_UNESCAPED_UNICODE)
                ]);

                $tong += $line;
            }

            DB::table('DonHang')->where('ID_DonHang', $idDon)->update([
                'TongTien' => $tong
            ]);

            DB::commit();

            session()->forget('cart');

            return redirect()->route('cart.success', $idDon);


        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }



    public function payment($id)
{
    $don = DB::table('DonHang')->where('ID_DonHang', $id)->first();

    if (!$don) {
        return redirect()->route('menu')->with('error', 'Không tìm thấy đơn hàng!');
    }

    // Tạo mã đơn giống Flutter
    $maDon = "DH{$id}";

    // QR config
    $bankId = 'VCB';
    $accountNumber = '103032294';
    $accountName = 'LUONG QUOC HUY';

    $qrUrl =
        "https://img.vietqr.io/image/{$bankId}-{$accountNumber}-compact2.jpg" .
        "?amount=" . intval($don->TongTien) .
        "&addInfo=" . urlencode($maDon) .
        "&accountName=" . urlencode($accountName);

    return view('frontend.payment', [
        'don'   => $don,
        'qrUrl' => $qrUrl,
        'maDon' => $maDon
    ]);
}
public function orderSuccess($id)
{
    $userId = Auth::id();

    // Lấy đúng đơn hàng của user
    $order = DB::table('DonHang')
        ->where('ID_DonHang', $id)
        ->where('ID_KhachHang', function ($q) use ($userId) {
            $q->select('ID_KhachHang')
              ->from('KhachHang')
              ->where('ID_User', $userId)
              ->limit(1);
        })
        ->first();

    if (!$order) {
        return redirect()->route('menu')
            ->with('error', 'Không tìm thấy đơn hàng!');
    }

    return view('frontend.order_success', compact('order'));
}

public function confirmPayment($id)
{
    // Chỉ xử lý đơn của đúng user
    $userId = Auth::id();

    $don = DB::table('DonHang')
        ->where('ID_DonHang', $id)
        ->where('ID_KhachHang', function ($q) use ($userId) {
            $q->select('ID_KhachHang')
              ->from('KhachHang')
              ->where('ID_User', $userId)
              ->limit(1);
        })
        ->first();

    if (!$don) {
        return back()->with('error', 'Không tìm thấy đơn hàng!');
    }

    // Không cho update nếu đã thanh toán hoặc hủy
    if ($don->TrangThai !== 'CHUA_THANH_TOAN') {
        return back()->with('error', 'Đơn này đã được xử lý trước đó!');
    }

    DB::table('DonHang')
        ->where('ID_DonHang', $id)
        ->update([
            'TrangThai' => 'DA_THANH_TOAN'
        ]);

    return back()->with('success', '✅ Xác nhận thanh toán thành công!');
}



}
