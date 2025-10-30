<?php

namespace App\Models;

class Size extends BaseModel
{
    protected $table = 'Size';
    protected $primaryKey = 'ID_Size';

    protected $casts = [
        'GiaTang' => 'decimal:2',
    ];
}
