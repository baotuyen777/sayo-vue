<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PdwsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        $rows = [
//            ['id' => 1, 'name' => 'Hà Nội', 'code' => 'hn', 'level' => 1],
//            ['id' => 2, 'name' => 'Thanh Xuân', 'code' => 'hn-tx', 'parent_id' => 1, 'level' => 2],
//
//            ['id' => 3, 'name' => 'Đống Đa', 'code' => 'hn-dd', 'parent_id' => 1, 'level' => 2],
//            ['id' => 4, 'name' => 'TP. Hồ Chí Minh', 'code' => 'hcm', 'level' => 1],
//
//            ['name' => 'Thanh Xuân Bắc', 'code' => 'hn-tx-txb', 'parent_id' => 2, 'level' => 3],
//            ['name' => 'Thanh Xuân Nam', 'code' => 'hn-tx-txn', 'parent_id' => 2, 'level' => 3],
//            ['name' => 'Trung Văn', 'code' => 'hn-tx-tv', 'parent_id' => 2, 'level' => 3],
//            ['name' => 'Nhân Chính', 'code' => 'hn-tx-nc', 'parent_id' => 2, 'level' => 3],
//        ];
        $rows = [
            ['name' => "Hà Nội", "code" => "Hà Nội", "level" => 1],
            ['name' => "Tp Hồ Chí Minh", "code" => "Tp Hồ Chí Minh", "level" => 1],
            ['name' => "Đà Nẵng", "code" => "Đà Nẵng", "level" => 1],
            ['name' => "Cần Thơ", "code" => "Cần Thơ", "level" => 1],
            ['name' => "Bình Dương", "code" => "Bình Dương", "level" => 1],
            ['name' => "An Giang", "code" => "An Giang", "level" => 1],
            ['name' => "Bà Rịa - Vũng Tàu", "code" => "Bà Rịa Vũng Tàu", "level" => 1],
            ['name' => "Bắc Giang", "code" => "Bắc Giang", "level" => 1],
            ['name' => "Bắc Kạn", "code" => "Bắc Kạn", "level" => 1],
            ['name' => "Bạc Liêu", "code" => "Bạc Liêu", "level" => 1],
            ['name' => "Bắc Ninh", "code" => "Bắc Ninh", "level" => 1],
            ['name' => "Bến Tre", "code" => "Bến Tre", "level" => 1],
            ['name' => "Bình Định", "code" => "Bình Định", "level" => 1],
            ['name' => "Bình Phước", "code" => "Bình Phước", "level" => 1],
            ['name' => "Bình Thuận", "code" => "Bình Thuận", "level" => 1],
            ['name' => "Cà Mau", "code" => "Cà Mau", "level" => 1],
            ['name' => "Cao Bằng", "code" => "Cao Bằng", "level" => 1],
            ['name' => "Đắk Lắk", "code" => "Đắk Lắk", "level" => 1],
            ['name' => "Đắk Nông", "code" => "Đắk Nông", "level" => 1],
            ['name' => "Điện Biên", "code" => "Điện Biên", "level" => 1],
            ['name' => "Đồng Nai", "code" => "Đồng Nai", "level" => 1],
            ['name' => "Đồng Tháp", "code" => "Đồng Tháp", "level" => 1],
            ['name' => "Gia Lai", "code" => "Gia Lai", "level" => 1],
            ['name' => "Hà Giang", "code" => "Hà Giang", "level" => 1],
            ['name' => "Hà Nam", "code" => "Hà Nam", "level" => 1],
            ['name' => "Hà Tĩnh", "code" => "Hà Tĩnh", "level" => 1],
            ['name' => "Hải Dương", "code" => "Hải Dương", "level" => 1],
            ['name' => "Hải Phòng", "code" => "Hải Phòng", "level" => 1],
            ['name' => "Hậu Giang", "code" => "Hậu Giang", "level" => 1],
            ['name' => "Hòa Bình", "code" => "Hòa Bình", "level" => 1],
            ['name' => "Hưng Yên", "code" => "Hưng Yên", "level" => 1],
            ['name' => "Khánh Hòa", "code" => "Khánh Hòa", "level" => 1],
            ['name' => "Kiên Giang", "code" => "Kiên Giang", "level" => 1],
            ['name' => "Kon Tum", "code" => "Kon Tum", "level" => 1],
            ['name' => "Lai Châu", "code" => "Lai Châu", "level" => 1],
            ['name' => "Lâm Đồng", "code" => "Lâm Đồng", "level" => 1],
            ['name' => "Lạng Sơn", "code" => "Lạng Sơn", "level" => 1],
            ['name' => "Lào Cai", "code" => "Lào Cai", "level" => 1],
            ['name' => "Long An", "code" => "Long An", "level" => 1],
            ['name' => "Nam Định", "code" => "Nam Định", "level" => 1],
            ['name' => "Nghệ An", "code" => "Nghệ An", "level" => 1],
            ['name' => "Ninh Bình", "code" => "Ninh Bình", "level" => 1],
            ['name' => "Ninh Thuận", "code" => "Ninh Thuận", "level" => 1],
            ['name' => "Phú Thọ", "code" => "Phú Thọ", "level" => 1],
            ['name' => "Phú Yên", "code" => "Phú Yên", "level" => 1],
            ['name' => "Quảng Bình", "code" => "Quảng Bình", "level" => 1],
            ['name' => "Quảng Nam", "code" => "Quảng Nam", "level" => 1],
            ['name' => "Quảng Ngãi", "code" => "Quảng Ngãi", "level" => 1],
            ['name' => "Quảng Ninh", "code" => "Quảng Ninh", "level" => 1],
            ['name' => "Quảng Trị", "code" => "Quảng Trị", "level" => 1],
            ['name' => "Sóc Trăng", "code" => "Sóc Trăng", "level" => 1],
            ['name' => "Sơn La", "code" => "Sơn La", "level" => 1],
            ['name' => "Tây Ninh", "code" => "Tây Ninh", "level" => 1],
            ['name' => "Thái Bình", "code" => "Thái Bình", "level" => 1],
            ['name' => "Thái Nguyên", "code" => "Thái Nguyên", "level" => 1],
            ['name' => "Thanh Hóa", "code" => "Thanh Hóa", "level" => 1],
            ['name' => "Thừa Thiên Huế", "code" => "Thừa Thiên Huế", "level" => 1],
            ['name' => "Tiền Giang", "code" => "Tiền Giang", "level" => 1],
            ['name' => "Trà Vinh", "code" => "Trà Vinh", "level" => 1],
            ['name' => "Tuyên Quang", "code" => "Tuyên Quang", "level" => 1],
            ['name' => "Vĩnh Long", "code" => "Vĩnh Long", "level" => 1],
            ['name' => "Vĩnh Phúc", "code" => "Vĩnh Phúc", "level" => 1],
            ['name' => "Yên Bái", "code" => "Yên Bái", "level" => 1],
        ];
        foreach ($rows as $row) {
//            array_merge($row, ['content' => '', 'parent_id' => 0, 'user_id' => 1]);
            $row['code'] = strtolower(vn2str($row['code']));
            DB::table('pdws')->insert($row);
        }
    }
}
