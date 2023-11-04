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
//            PdwsSeeder::class,
            FilesSeeder::class,
            DepartmentSeeder::class,
            UserSeeder::class,
            CategoriesSeeder::class,
            SettingsSeeder::class,
            PostsSeeder::class,
            ProductsSeeder::class,
//            NewsSeeder::class,

        ]);
    }
}
