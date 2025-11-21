<?php

namespace App\Models;

class DonHang extends BaseModel
{
    protected $table = 'DonHang';
    protected $primaryKey = 'ID_DonHang';

    protected $casts = [
        'ThoiGian' => 'datetime',
        'TongTien' => 'decimal:2',
    ];

    public $timestamps = false;

    protected $fillable = [
        'ID_KhachHang',
        'ID_Ban',
        'ThoiGian',
        'TrangThai',
        'TongTien',
        'GhiChu',
    ];

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'ID_KhachHang', 'ID_KhachHang');
    }

    public function ban()
    {
        return $this->belongsTo(Ban::class, 'ID_Ban', 'ID_Ban');
    }

    public function chiTiet()
    {
        return $this->hasMany(ChiTietDonHang::class, 'ID_DonHang', 'ID_DonHang');
    }

    public function thanhToans()
    {
        return $this->hasMany(ThanhToan::class, 'ID_DonHang', 'ID_DonHang');
    }

    // Scopes tiện lọc theo trạng thái
    public function scopeChuaThanhToan($q){ return $q->where('TrangThai','CHUA_THANH_TOAN'); }
    public function scopeDaThanhToan($q){ return $q->where('TrangThai','DA_THANH_TOAN'); }
    public function scopeHuyDon($q){ return $q->where('TrangThai','HUY_DON'); }
}
