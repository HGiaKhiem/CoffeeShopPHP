<?php

namespace App\Models;

class ThanhToan extends BaseModel
{
    protected $table = 'ThanhToan';
    protected $primaryKey = 'ID_ThanhToan';

    protected $casts = [
        'ThoiGian' => 'datetime',
        'SoTien'   => 'decimal:2',
    ];

    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'ID_DonHang', 'ID_DonHang');
    }
}
