<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'ID_Review';
    public $timestamps = false;

    protected $fillable = [
        'ID_KhachHang',
        'ID_Mon',
        'ID_DonHang',
        'Rating',
        'NoiDung',
        'NgayTao',
    ];
}
