<?php

namespace App\Models;

class Mon extends BaseModel
{
    protected $table = 'Mon';
    protected $primaryKey = 'ID_Mon';

    protected $casts = [
        'Gia' => 'decimal:2',
        'TrangThai' => 'boolean',
    ];

    public function loaiMon()
    {
        return $this->belongsTo(LoaiMon::class, 'ID_LoaiMon', 'ID_LoaiMon');
    }

    public function chiTietDonHangs()
    {
        return $this->hasMany(ChiTietDonHang::class, 'ID_Mon', 'ID_Mon');
    }
}
