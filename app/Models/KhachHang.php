<?php

namespace App\Models;

class KhachHang extends BaseModel
{
    protected $table = 'KhachHang';
    protected $primaryKey = 'ID_KhachHang';

    protected $casts = [
        'NgayTao' => 'datetime',
        'DiemTichLuy' => 'integer',
    ];

    public function donHangs()
    {
        return $this->hasMany(DonHang::class, 'ID_KhachHang', 'ID_KhachHang');
    }
}
