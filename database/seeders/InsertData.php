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
        DB::table('KhachHang')->insertOrIgnore([
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
        DB::table('Ban')->insertOrIgnore($banRows);

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
            ['TenLoaiMon' => 'Mattcha'],     // ID_LoaiMon = 8 
        ]);
         // --- Mon ---
        DB::table('Mon')->insertOrIgnore([
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
        DB::table('Topping')->insertOrIgnore([
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

        // --- Fake orders (DonHang + ChiTietDonHang + ThanhToan) ---
        // Only seed if we don't already have many orders to avoid duplicates.
        $existingOrders = DB::table('DonHang')->count();
        if ($existingOrders < 100) {
            // fetch ids and prices for menu items
            $monRows = DB::table('Mon')->select('ID_Mon', 'Gia')->get()->toArray();
            $monMap = [];
            foreach ($monRows as $m) {
                $monMap[$m->ID_Mon] = (float) $m->Gia;
            }

            $khIds = DB::table('KhachHang')->pluck('ID_KhachHang')->toArray();
            $banIds = DB::table('Ban')->pluck('ID_Ban')->toArray();

            // prepare days range (last 60 days)
            $days = 60;
            $ordersCreated = 0;
            for ($d = $days - 1; $d >= 0; $d--) {
                // random orders per day (0..4)
                $num = rand(0, 4);
                for ($i = 0; $i < $num; $i++) {
                    if ($ordersCreated + $existingOrders >= 300) break 2; // cap total

                    // random time during the day
                    $date = (new \DateTime())->modify("-{$d} days");
                    $hour = rand(8, 21);
                    $min = rand(0, 59);
                    $sec = rand(0, 59);
                    $date->setTime($hour, $min, $sec);
                    $thoiGian = $date->format('Y-m-d H:i:s');

                    // choose a random customer or null (walk-in)
                    $idKh = null;
                    if (!empty($khIds) && rand(0, 4) > 0) { // 80% chance pick
                        $idKh = $khIds[array_rand($khIds)];
                    }

                    // choose a table sometimes
                    $idBan = null;
                    if (!empty($banIds) && rand(0, 3) === 0) { // 25% chance
                        $idBan = $banIds[array_rand($banIds)];
                    }

                    // build order items
                    $monKeys = array_keys($monMap);
                    if (empty($monKeys)) break 2; // no menu items

                    $numItems = rand(1, 4);
                    $tong = 0.0;
                    $chiTietRows = [];
                    for ($it = 0; $it < $numItems; $it++) {
                        $mid = $monKeys[array_rand($monKeys)];
                        $gia = $monMap[$mid];
                        $qty = rand(1, 3);
                        $thanh = $gia * $qty;
                        $tong += $thanh;

                        $chiTietRows[] = [
                            'ID_Mon' => $mid,
                            'SoLuong' => $qty,
                            'GiaBan' => $gia,
                            'TuyChon_JSON' => null,
                            'ThanhTien' => $thanh,
                        ];
                    }

                    // random status: mostly paid
                    $status = (rand(0, 9) < 8) ? 'DA_THANH_TOAN' : 'CHUA_THANH_TOAN';

                    // insert order
                    $donId = DB::table('DonHang')->insertGetId([
                        'ID_KhachHang' => $idKh,
                        'ID_Ban' => $idBan,
                        'ThoiGian' => $thoiGian,
                        'TrangThai' => $status,
                        'TongTien' => $tong,
                        'GhiChu' => null,
                    ], 'ID_DonHang');

                    // insert chi tiết
                    foreach ($chiTietRows as $ct) {
                        DB::table('ChiTietDonHang')->insert([
                            'ID_DonHang' => $donId,
                            'ID_Mon' => $ct['ID_Mon'],
                            'SoLuong' => $ct['SoLuong'],
                            'GiaBan' => $ct['GiaBan'],
                            'TuyChon_JSON' => $ct['TuyChon_JSON'],
                            'ThanhTien' => $ct['ThanhTien'],
                        ]);
                    }

                    // if paid, insert a ThanhToan record
                    if ($status === 'DA_THANH_TOAN') {
                        $methods = ['Tiền mặt', 'Momo', 'Thẻ'];
                        DB::table('ThanhToan')->insert([
                            'ID_DonHang' => $donId,
                            'PhuongThuc' => $methods[array_rand($methods)],
                            'SoTien' => $tong,
                            'ThoiGian' => $thoiGian,
                            'GhiChu' => null,
                        ]);
                    }

                    $ordersCreated++;
                }
            }
        }
    }
}
