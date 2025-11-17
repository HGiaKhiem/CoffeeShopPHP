<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Tạo user trong bảng users
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Tạo khách hàng trong bảng KhachHang
        $idKhach = DB::table('KhachHang')->insertGetId([
            'TenKH'        => $request->name,
            'Email'        => $request->email,
            'SDT'          => null,
            'HangThanhVien'=> 'Thuong',
            'DiemTichLuy'  => 0,
            'ID_User'      => $user->id,
            'NgayTao'      => now(),
        ]);

        // Lưu vào session
        session(['khachhang_id' => $idKhach]);

        Auth::login($user);

        return redirect()->route('home');
    }
}
