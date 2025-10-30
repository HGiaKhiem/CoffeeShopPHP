<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    // Các bảng của bạn không dùng created_at/updated_at mặc định
    public $timestamps = false;

    // Cho phép gán hàng loạt (tuỳ team có thể chuyển sang $fillable)
    protected $guarded = [];
}
