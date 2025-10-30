<?php

namespace App\Models;

class Topping extends BaseModel
{
    protected $table = 'Topping';
    protected $primaryKey = 'ID_Topping';

    protected $casts = [
        'GiaTang' => 'decimal:2',
    ];
}
