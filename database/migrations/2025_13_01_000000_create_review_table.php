<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('ID_Review');

            // Foreign key: Khách hàng
            $table->unsignedBigInteger('ID_KhachHang');

            // Foreign key: Món
            $table->unsignedBigInteger('ID_Mon');

            // Foreign key: Đơn hàng
            $table->unsignedBigInteger('ID_DonHang');

            // Rating 1–5
            $table->unsignedTinyInteger('Rating');

            // Nội dung đánh giá
            $table->text('NoiDung')->nullable();

            // Ngày tạo
            $table->timestamp('NgayTao')->useCurrent();

            // --- Foreign keys ---
            $table->foreign('ID_KhachHang')
                ->references('ID_KhachHang')->on('khachhang')
                ->onDelete('cascade');

            $table->foreign('ID_Mon')
                ->references('ID_Mon')->on('mon')
                ->onDelete('cascade');

            $table->foreign('ID_DonHang')
                ->references('ID_DonHang')->on('donhang')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
