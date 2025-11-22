<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('DonHang', function (Blueprint $t) {
            $t->string('DiaChi', 300)->nullable()->after('TongTien');
            $t->string('SDT_NhanHang', 20)->nullable()->after('DiaChi');
            $t->string('PhuongThucThanhToan', 30)->nullable()->after('SDT_NhanHang');
        });
    }

    public function down(): void
    {
        Schema::table('DonHang', function (Blueprint $t) {
            $t->dropColumn(['DiaChi', 'SDT_NhanHang', 'PhuongThucThanhToan']);
        });
    }
};

