<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('khachhang', function (Blueprint $table) {
            if (!Schema::hasColumn('khachhang', 'ID_User')) {
                $table->unsignedBigInteger('ID_User')->nullable()->after('ID_KhachHang');
                $table->foreign('ID_User')
                      ->references('id')
                      ->on('users')
                      ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('khachhang', function (Blueprint $table) {
            if (Schema::hasColumn('khachhang', 'ID_User')) {
                $table->dropForeign(['ID_User']);
                $table->dropColumn('ID_User');
            }
        });
    }
};
