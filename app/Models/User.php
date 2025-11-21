<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\KhachHang;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Kiểm tra có phải admin không
     */
    public function isAdmin(): bool
    {
        return isset($this->role) && $this->role === 'admin';
    }

    // 🔹 Quan hệ: Một User có một KhachHang
    public function khachHang()
    {
        return $this->hasOne(KhachHang::class, 'ID_User', 'id');
    }

    // 🔹 Khi user được tạo -> tự động tạo KhachHang tương ứng
    protected static function booted()
    {
        static::created(function ($user) {
            // Kiểm tra tránh tạo trùng nếu đã có
            if (!$user->khachHang) {
                KhachHang::create([
                    'ID_User'        => $user->id,
                    'TenKH'          => $user->name,
                    'Email'          => $user->email,
                    'SDT'            => null,
                    'HangThanhVien'  => 'Thuong',
                    'DiemTichLuy'    => 0,
                    'NgayTao'        => now(),
                ]);
            }
        });

        // (Tùy chọn) Khi xóa user -> xóa luôn KhachHang
        static::deleting(function ($user) {
            if ($user->khachHang) {
                $user->khachHang->delete();
            }
        });
    }
}
