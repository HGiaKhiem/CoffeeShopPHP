<?php

namespace App\Models;

class LoaiMon extends BaseModel
{
    protected $table = 'LoaiMon';
    protected $primaryKey = 'ID_LoaiMon';

    protected $fillable = [
        'TenLoaiMon',
    ];

    public function mons()
    {
        return $this->hasMany(Mon::class, 'ID_LoaiMon', 'ID_LoaiMon');
    }
}
