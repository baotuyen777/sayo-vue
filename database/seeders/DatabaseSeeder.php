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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
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
    }
}
