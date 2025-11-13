<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // --- KhachHang ---
        DB::table('KhachHang')->insert([
            [
                'TenKH' => 'Nguyễn Văn A',
                'SDT' => '0911111111',
                'Email' => 'nguyenvana@gmail.com',
                'HangThanhVien' => 'Thuong',
                'DiemTichLuy' => 0,
            ],
            [   
                'TenKH' => 'Trần Thị B',
                'SDT' => '0922222222',
                'Email' => 'tranthib@gmail.com',
                'HangThanhVien' => 'Thuong',
                'DiemTichLuy' => 0,
            ],
            [
                'TenKH' => 'Lê Văn C',
                'SDT' => '0933333333',
                'Email' => 'levanc@yahoo.com',
                'HangThanhVien' => 'Thuong',
                'DiemTichLuy' => 0,
            ],
        ]);

        // --- Ban (20 bàn, chỉ có SoBan; các cột khác sẽ dùng default) ---
        $banRows = [];
        for ($i = 1; $i <= 20; $i++) {
            $banRows[] = [
                'SoBan' => $i,
                // 'TrangThai' => default 'Trống'
                // 'QR_Token' => null by default
            ];
        }
        DB::table('Ban')->insert($banRows);

        // --- Size ---
        DB::table('Size')->insert([
            [
                'TenSize' => 'S',
                'GiaTang' => 0,
            ],
            [
                'TenSize' => 'M',
                'GiaTang' => 3000,
            ],
            [
                'TenSize' => 'L',
                'GiaTang' => 5000,
            ],
        ]);

        // --- LoaiMon ---
        DB::table('LoaiMon')->insert([
            ['TenLoaiMon' => 'Cà phê'],      // ID_LoaiMon = 1
            ['TenLoaiMon' => 'Trà'],         // ID_LoaiMon = 2
            ['TenLoaiMon' => 'Trà sữa'],     // ID_LoaiMon = 3
            ['TenLoaiMon' => 'Nước ép'],     // ID_LoaiMon = 4
            ['TenLoaiMon' => 'Sinh tố'],     // ID_LoaiMon = 5
            ['TenLoaiMon' => 'Soda'],        // ID_LoaiMon = 6
            ['TenLoaiMon' => 'Sữa chua'],    // ID_LoaiMon = 7
            ['TenLoaiMon' => 'Mattcha'],     // ID_LoaiMon = 8 (bạn đánh "Mattcha", mình giữ nguyên)
        ]);
         // --- Mon ---
        DB::table('Mon')->insert([
            // Cà phê (ID_LoaiMon = 1)
            ['TenMon' => 'Cà phê đen',            'ID_LoaiMon' => 1, 'Gia' => 20000, 'TrangThai' => true],
            ['TenMon' => 'Cà phê sữa',            'ID_LoaiMon' => 1, 'Gia' => 25000, 'TrangThai' => true],
            ['TenMon' => 'Bạc xỉu',               'ID_LoaiMon' => 1, 'Gia' => 25000, 'TrangThai' => true],
            ['TenMon' => 'Cà phê muối',           'ID_LoaiMon' => 1, 'Gia' => 20000, 'TrangThai' => true],

            // Trà (ID_LoaiMon = 2)
            ['TenMon' => 'Trà đào cam sả',        'ID_LoaiMon' => 2, 'Gia' => 30000, 'TrangThai' => true],
            ['TenMon' => 'Trà chanh mật ong',     'ID_LoaiMon' => 2, 'Gia' => 30000, 'TrangThai' => true],
            ['TenMon' => 'Hồng trà',              'ID_LoaiMon' => 2, 'Gia' => 30000, 'TrangThai' => true],
            ['TenMon' => 'Trà nhãn',              'ID_LoaiMon' => 2, 'Gia' => 30000, 'TrangThai' => true],
            ['TenMon' => 'Lục trà',               'ID_LoaiMon' => 2, 'Gia' => 30000, 'TrangThai' => true],

            // Trà sữa (ID_LoaiMon = 3)
            ['TenMon' => 'Trà sữa truyền thống',  'ID_LoaiMon' => 3, 'Gia' => 25000, 'TrangThai' => true],
            ['TenMon' => 'Trà sữa Olong',         'ID_LoaiMon' => 3, 'Gia' => 30000, 'TrangThai' => true],
            ['TenMon' => 'Sữa tươi đường đen',    'ID_LoaiMon' => 3, 'Gia' => 30000, 'TrangThai' => true],
            ['TenMon' => 'Trà sữa kem cheese',    'ID_LoaiMon' => 3, 'Gia' => 30000, 'TrangThai' => true],

            // Nước ép (ID_LoaiMon = 4)
            ['TenMon' => 'Nước ép cam',           'ID_LoaiMon' => 4, 'Gia' => 25000, 'TrangThai' => true],
            ['TenMon' => 'Nước ép ổi',            'ID_LoaiMon' => 4, 'Gia' => 25000, 'TrangThai' => true],
            ['TenMon' => 'Nước ép dưa hấu',       'ID_LoaiMon' => 4, 'Gia' => 25000, 'TrangThai' => true],
            ['TenMon' => 'Nước ép táo',           'ID_LoaiMon' => 4, 'Gia' => 25000, 'TrangThai' => true],
            ['TenMon' => 'Nước ép thơm',          'ID_LoaiMon' => 4, 'Gia' => 25000, 'TrangThai' => true],

            // Sinh tố (ID_LoaiMon = 5)
            ['TenMon' => 'Sinh tố dâu',           'ID_LoaiMon' => 5, 'Gia' => 30000, 'TrangThai' => true],
            ['TenMon' => 'Sinh tố bơ',            'ID_LoaiMon' => 5, 'Gia' => 30000, 'TrangThai' => true],
            ['TenMon' => 'Sinh tố dừa',           'ID_LoaiMon' => 5, 'Gia' => 25000, 'TrangThai' => true],
            ['TenMon' => 'Sinh tố mãng cầu',      'ID_LoaiMon' => 5, 'Gia' => 30000, 'TrangThai' => true],

            // Soda (ID_LoaiMon = 6)
            ['TenMon' => 'Soda blue',             'ID_LoaiMon' => 6, 'Gia' => 20000, 'TrangThai' => true],
            ['TenMon' => 'Soda dâu',              'ID_LoaiMon' => 6, 'Gia' => 20000, 'TrangThai' => true],
            ['TenMon' => 'Soda bạc hà',           'ID_LoaiMon' => 6, 'Gia' => 20000, 'TrangThai' => true],

            // Sữa chua (ID_LoaiMon = 7)
            ['TenMon' => 'Sữa chua việt quất',    'ID_LoaiMon' => 7, 'Gia' => 30000, 'TrangThai' => true],
            ['TenMon' => 'Sữa chua dâu',          'ID_LoaiMon' => 7, 'Gia' => 30000, 'TrangThai' => true],
            ['TenMon' => 'Sữa chua chanh dây',    'ID_LoaiMon' => 7, 'Gia' => 30000, 'TrangThai' => true],

            // "Mattcha" (ID_LoaiMon = 8)
            ['TenMon' => 'Matcha latte',          'ID_LoaiMon' => 8, 'Gia' => 30000, 'TrangThai' => true],
            ['TenMon' => 'Matcha kem phô mai',    'ID_LoaiMon' => 8, 'Gia' => 30000, 'TrangThai' => true],
        ]);

        // --- Topping ---
        DB::table('Topping')->insert([
            [
                'TenTopping' => 'Chân trâu đen',
                'GiaTang' => 5000,
            ],
            [
                'TenTopping' => 'Chân trâu trắng',
                'GiaTang' => 5000,
            ],
            [
                'TenTopping' => 'Thạch',
                'GiaTang' => 5000,
            ],
        ]);
    }
}
