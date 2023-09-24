<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        DB::table('files')->insert(['name' => 1, 'url' => 'uploads/2023-08-12/3f115d4b4d8285dcdc93.jpg']);
//        DB::table('files')->insert(['name' => 2, 'url' => 'uploads/2023-08-12/33.jpg']);

        $this->call([
//            PdwsSeeder::class,
            FilesSeeder::class,
            DepartmentSeeder::class,
            UserSeeder::class,
            CategoriesSeeder::class,
            SettingsSeeder::class,
            PostsSeeder::class,


        ]);

        for ($i = 1; $i < 10; $i++) {
            DB::table('products')->insert([
                'name' => 'product ' . $i,
                'code' => 'code ' . $i,
                'content' => 'value ' . $i,
                'category_id' => rand(1, 5),
                'user_id' => 1,
            ]);

            DB::table('orders')->insert([
                'user_id' => 1,
            ]);
        }


        DB::table('posts_files')->insert([
            'posts_id' => 1,
            'files_id' => 1,
        ]);
        DB::table('posts_files')->insert([
            'posts_id' => 1,
            'files_id' => 2,
        ]);
    }
}
