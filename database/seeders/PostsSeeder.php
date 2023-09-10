<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        $faker = \Faker\Factory::create();

//        for ($i = 1; $i < 10; $i++) {
//
//            DB::table('posts')->insert([
//                'name' => $faker->name . $faker->name . $faker->name . $faker->name . $faker->name . '__' . $i,
//                'code' => time() . '_' . $i,
//                'content' => 'value ' . $i,
//                'category_id' => 1,
//                'avatar_id' => rand(1, 2),
//                'author_id' => 1,
//                'ward_id' => 5,
//                'district_id' => 2,
//                'province_id' => 1,
//                'price' => rand(50000, 2400000000),
//                'attr' => json_encode(['material' => 'Gỗ']),
//                'created_at'=> Carbon::now(),
//            ]);
//        }
        for ($i = 1; $i < 10; $i++) {
            DB::table('posts')->insert([
                'name' => 'Cho thuê phòng tuyệt đẹp, đầy đủ tiện nghi, thuận tiện giao thông, ngõ 116 Miếu Đầm',
                'code' => time() . $i,
                'content' => 'Chính chủ em có phòng tại số nhà 25 ngõ 116 Miếu Đầm, diện tích 35m² thiết kế theo tiêu chuẩn khách sạn, cửa gỗ lim, khóa cửa phòng mở theo mã số, phòng có cửa sổ, ban công có nhiều ánh sáng và thoáng.
Nhà đầy đủ tiện nghi điều hòa, bình nóng lạnh, giường và tủ quần áo, bàn ghế shopha, tủ lạnh, tủ bếp trên dưới, bếp từ, máy giặt và máy sấy, thang máy tốc độ cao, khóa Vân tay đi lại tự do.
Nhà gần chợ, gần đường lớn, chỉ mấy bước chân ra Phạm Hùng, Keang Nam, gần nhiều trường mầm non, gần nhiều khi vui chơi giải trí ăn uống..
Giá thuê chỉ từ 5,2tr tới 5,5tr/ tháng tùy căn.
Ngoài ra có căn hộ 1 ngủ 1 khách diện tích 40m², full đồ giá là : 5,5tr /tháng',
                'category_id' => 1,
                'avatar_id' => 1,
                'author_id' => 1,
                'ward_id' => rand(1, 10),
                'district_id' => 1,
                'province_id' => 1,
                'price' => rand(1000000, 5000000),
                'attr' => json_encode(['acreage' => '35', 'garret' => '1', 'deposit' => 2000000, 'furniture' => 1]),
                'created_at' => Carbon::now(),
            ]);

            DB::table('posts')->insert([
                'name' => 'Cho thuê Căn hộ dịch vụ mini 25m siêu đẹp, mặt đường Nguyễn Đình Chiểu, đầy đủ đồ vào ở ngay. giá rẻ chỉ 5 triệu',
                'code' => time() . '_2' . $i,
                'content' => 'Cho thuê căn hộ mini mặt phố, số 24 Nguyễn Đình Chiểu, P.Lê Đại Hành, Q.HBT, HN. Diện tích 25m, mặt tiền 6m, rất thoáng mát, cửa sổ nhìn thẳng ra đường. Đầy đủ tiện nghi, 1 bếp, 1 phòng vệ sinh, chỉ việc xách vali vào ở luôn. Căn hộ khép kín, lối đi riêng biệt.

Cách công viên Thống nhất 100m, không khí thoáng mát, trong lành.',
                'category_id' => 1,
                'avatar_id' => 2,
                'author_id' => 1,
                'ward_id' => rand(1, 10),
                'district_id' => 1,
                'province_id' => 1,
                'price' => rand(1000000, 5000000),
                'attr' => json_encode(['acreage' => '35', 'garret' => '1', 'deposit' => 2000000, 'furniture' => 1]),
                'created_at' => Carbon::now(),
            ]);
        }
        for ($i = 1; $i <= 4; $i++) {
            DB::table('posts_files')->insert([
                'posts_id' => 1,
                'files_id' => $i
            ]);
            DB::table('posts_files')->insert([
                'posts_id' => 2,
                'files_id' => $i
            ]);
        }


    }
}
