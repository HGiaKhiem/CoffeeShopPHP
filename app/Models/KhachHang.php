<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    use HasFactory;

    protected $table = 'khachhang';
    protected $primaryKey = 'ID_KhachHang';
    public $timestamps = false; // Vì bạn dùng cột NgayTao thủ công

    protected $fillable = [
        'ID_User',
        'TenKH',
        'SDT',
        'Email',
        'HangThanhVien',
        'DiemTichLuy',
        'NgayTao',
    ];

    public $timestamps = false;

    protected $fillable = [
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
