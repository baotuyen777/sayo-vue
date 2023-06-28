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
        $this->call([
            DepartmentSeeder::class,
            UserStatusSeeder::class,
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

        DB::table('medias')->insert([
            'name' => 1,
            'url' => 2,
        ]);
    }
}
