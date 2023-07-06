<?php

namespace Database\Seeders;

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
        for ($i = 1; $i < 10; $i++) {
            DB::table('posts')->insert([
                'name' => 'post ' . $i,
                'code' => 'code ' . $i,
                'content' => 'value ' . $i,
                'category_id' => 1,
//                'avatar_id' => 1,
                'user_id' => 1,
            ]);
        }



    }
}
