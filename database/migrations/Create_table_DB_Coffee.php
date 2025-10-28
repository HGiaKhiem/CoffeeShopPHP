<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1) KhachHang
        Schema::create('KhachHang', function (Blueprint $t) {
            $t->bigIncrements('ID_KhachHang');
            $t->string('TenKH', 100);
            $t->string('SDT', 20)->unique()->nullable();
            $t->string('Email', 255)->nullable();

            // Dùng enum thay cho CHECK
            $t->enum('HangThanhVien', ['Thuong', 'VIP'])->nullable();

            $t->integer('DiemTichLuy')->default(0);
            // Giữ trường NgayTao theo yêu cầu (không dùng timestamps())
            $t->timestamp('NgayTao')->useCurrent();
        });

        // 2) Ban
        Schema::create('Ban', function (Blueprint $t) {
            $t->bigIncrements('ID_Ban');
            $t->integer('SoBan')->unique();

            // enum portable
            $t->enum('TrangThai', ['Trống', 'Có khách', 'Đặt trước', 'Khóa'])
              ->default('Trống');

            // Tránh default DB-specific cho UUID, set ở tầng ứng dụng
            $t->uuid('QR_Token')->nullable()->unique();
        });

        // 3) LoaiMon
        Schema::create('LoaiMon', function (Blueprint $t) {
            $t->bigIncrements('ID_LoaiMon');
            $t->string('TenLoaiMon', 200);
        });

        // 4) Mon
        Schema::create('Mon', function (Blueprint $t) {
            $t->bigIncrements('ID_Mon');
            $t->string('TenMon', 200);
            $t->unsignedBigInteger('ID_LoaiMon');

            // Dùng decimal chung; 18,2 là an toàn trên hầu hết hệ
            $t->decimal('Gia', 18, 2);

            $t->string('MoTa', 500)->nullable();
            $t->boolean('TrangThai')->default(true); // true: còn bán

            $t->foreign('ID_LoaiMon')->references('ID_LoaiMon')->on('LoaiMon');
            $t->index(['ID_LoaiMon', 'TrangThai']);
        });

        // 5) Topping
        Schema::create('Topping', function (Blueprint $t) {
            $t->bigIncrements('ID_Topping');
            $t->string('TenTopping', 200);
            $t->decimal('GiaTang', 18, 2)->default(0);
        });

        // 6) Size
        Schema::create('Size', function (Blueprint $t) {
            $t->bigIncrements('ID_Size');
            $t->string('TenSize', 50);
            $t->decimal('GiaTang', 18, 2)->default(0);
        });

        // 7) DonHang
        Schema::create('DonHang', function (Blueprint $t) {
            $t->bigIncrements('ID_DonHang');
            $t->unsignedBigInteger('ID_KhachHang')->nullable();
            $t->unsignedBigInteger('ID_Ban')->nullable();

            $t->timestamp('ThoiGian')->useCurrent();

            // enum portable thay cho CHECK
            $t->enum('TrangThai', ['CHUA_THANH_TOAN', 'DA_THANH_TOAN', 'HUY_DON'])
              ->default('CHUA_THANH_TOAN');

            $t->decimal('TongTien', 18, 2)->default(0);
            $t->string('GhiChu', 500)->nullable();

            $t->foreign('ID_KhachHang')->references('ID_KhachHang')->on('KhachHang');
            $t->foreign('ID_Ban')->references('ID_Ban')->on('Ban');
            $t->index(['ID_KhachHang', 'ID_Ban', 'TrangThai']);
        });

        // 8) ChiTietDonHang
        Schema::create('ChiTietDonHang', function (Blueprint $t) {
            $t->bigIncrements('ID_ChiTiet');
            $t->unsignedBigInteger('ID_DonHang');
            $t->unsignedBigInteger('ID_Mon');

            // Unsigned giúp tránh âm ở MySQL/MariaDB; PG/SQLite sẽ bỏ qua "unsigned"
            $t->unsignedInteger('SoLuong');

            $t->decimal('GiaBan', 18, 2);

            // Dùng json portable thay cho jsonb
            $t->json('TuyChon_JSON')->nullable();

            // KHÔNG dùng generated column để đảm bảo portable
            // Bạn có thể cập nhật ThanhTien ở tầng ứng dụng/trigger
            $t->decimal('ThanhTien', 18, 2)->default(0);

            $t->foreign('ID_DonHang')
              ->references('ID_DonHang')->on('DonHang')
              ->onDelete('cascade');

            $t->foreign('ID_Mon')->references('ID_Mon')->on('Mon');

            $t->index(['ID_DonHang', 'ID_Mon']);
        });

        // 9) ThanhToan
        Schema::create('ThanhToan', function (Blueprint $t) {
            $t->bigIncrements('ID_ThanhToan');
            $t->unsignedBigInteger('ID_DonHang');
            $t->string('PhuongThuc', 30);

            // Có thể dùng unsignedDecimal() ở Laravel mới; dùng decimal chung cho portable
            $t->decimal('SoTien', 18, 2);

            $t->timestamp('ThoiGian')->useCurrent();
            $t->string('GhiChu', 300)->nullable();

            $t->foreign('ID_DonHang')->references('ID_DonHang')->on('DonHang');
            $t->index(['ID_DonHang', 'ThoiGian']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ThanhToan');
        Schema::dropIfExists('ChiTietDonHang');
        Schema::dropIfExists('DonHang');
        Schema::dropIfExists('Size');
        Schema::dropIfExists('Topping');
        Schema::dropIfExists('Mon');
        Schema::dropIfExists('LoaiMon');
        Schema::dropIfExists('Ban');
        Schema::dropIfExists('KhachHang');
    }
};
