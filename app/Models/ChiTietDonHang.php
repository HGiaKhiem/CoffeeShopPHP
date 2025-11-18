<?php

namespace App\Models;

class ChiTietDonHang extends BaseModel
{
    protected $table = 'ChiTietDonHang';
    protected $primaryKey = 'ID_ChiTiet';

    public $timestamps = false;

    protected $fillable = [
        'ID_DonHang',
        'ID_Mon',
        'SoLuong',
        'GiaBan',
        'TuyChon_JSON',
        'ThanhTien',
    ];

    protected $casts = [
        'SoLuong' => 'integer',
        'GiaBan' => 'decimal:2',
        'ThanhTien' => 'decimal:2',
        'TuyChon_JSON' => 'array', // Eloquent tự json_encode/decode
    ];

    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'ID_DonHang', 'ID_DonHang');
    }

    public function mon()
    {
        return $this->belongsTo(Mon::class, 'ID_Mon', 'ID_Mon');
    }
}
