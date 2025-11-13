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

    // ==============================
    // QUAN HỆ CHÍNH
    // ==============================

    public function loaiMon()
    {
        return $this->belongsTo(LoaiMon::class, 'ID_LoaiMon', 'ID_LoaiMon');
    }

    public function chiTietDonHangs()
    {
        return $this->hasMany(ChiTietDonHang::class, 'ID_Mon', 'ID_Mon');
    }



    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'Mon_Size', 'ID_Mon', 'ID_Size')
                    ->withPivot('GiaTang')
                    ->withTimestamps();
    }


    public function toppings()
    {
        return $this->belongsToMany(Topping::class, 'Mon_Topping', 'ID_Mon', 'ID_Topping')
                    ->withPivot('GiaTang')
                    ->withTimestamps();
    }
}
