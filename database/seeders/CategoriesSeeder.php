<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class
CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            ['name' => 'Bất động sản', 'code' => 'bds'],
            ['name' => 'Đồ điện tử', 'code' => 'do-dien-tu'],
            ['name' => 'Đồ gia dụng', 'code' => 'do-gia-dung'],
            ['name' => 'Dịch vụ', 'code' => 'dich-vu'],
            ['name' => 'Mẹ và bé', 'code' => 'me-va-be'],
            ['name' => 'Thú cưng', 'code' => 'thu-cung'],
            ['name' => 'Đồ ăn', 'code' => 'do-an'],
            ['name' => 'Điện lạnh', 'code' => 'dien-lanh'],
            ['name' => 'Thời trang', 'code' => 'thoi-trang'],
            ['name' => 'Văn phòng', 'code' => 'van-phong'],
            ['name' => 'Cho tặng miễn phí', 'code' => 'cho-tang-mien-phi'],
            ['name' => 'Khác', 'code' => 'khac'],
        ];
        foreach ($rows as $row) {
            array_merge($row, ['content' => '', 'parent_id' => 0, 'user_id' => 1]);
            DB::table('categories')->insert($row);
        }

    }
}
