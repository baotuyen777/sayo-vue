<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::table('users')->where('role', 3)->first();
        $postComments = [
            [
                'id' => 1,
                'content' => 'Sản phẩm tốt, giá thành phải chăng',
                'item_id' => 1,
                'user_id' => $users->id,
                'parent_id' => null
            ],
            [
                'id' => 2,
                'content' => 'Bạn đã mua sản phẩm này có gán tem không',
                'item_id' => 1,
                'user_id' => $users->id,
                'parent_id' => 1
            ],
            [
                'id' => 3,
                'content' => 'Con này vs iphon11 128g thì con nào hơn ạ',
                'item_id' => 1,
                'user_id' => $users->id,
                'parent_id' => 2
            ],
            [
                'id' => 4,
                'content' => 'Cho mình hỏi mua máy cũ có được trả góp k, với mua ở tỉnh khác thì có ship về chỗ mình dc k ạ',
                'item_id' => 1,
                'user_id' => $users->id,
                'parent_id' => null
            ],
        ];
        DB::table('post_comment')->insert($postComments);
    }
}
