<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    use HasFactory;

    protected $table = 'khachhang';
    protected $primaryKey = 'ID_KhachHang';
    // Không dùng timestamps mặc định (bạn quản lý `NgayTao` thủ công)
    public $timestamps = false;

    // Các cột có thể được gán hàng loạt
    protected $fillable = [
        'ID_User',
        'TenKH',
        'SDT',
        'Email',
        'HangThanhVien',
        'DiemTichLuy',
        'NgayTao',
    ];

    protected $casts = [
        'NgayTao' => 'datetime',
        'DiemTichLuy' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'ID_User', 'id');
    }

    public function donHangs()
    {
        return $this->hasMany(DonHang::class, 'ID_KhachHang', 'ID_KhachHang');
    }
}
