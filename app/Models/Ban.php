<?php

namespace App\Models;

class Ban extends BaseModel
{
    protected $table = 'Ban';
    protected $primaryKey = 'ID_Ban';

    public function donHangs()
    {
        return $this->hasMany(DonHang::class, 'ID_Ban', 'ID_Ban');
    }
}
