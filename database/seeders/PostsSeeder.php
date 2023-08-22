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
        $faker = \Faker\Factory::create();

        for ($i = 1; $i < 10; $i++) {

            DB::table('posts')->insert([
                'name' => $faker->name . $faker->name . $faker->name . $faker->name . $faker->name . '__' . $i,
                'code' => time() . '_' . $i,
                'content' => 'value ' . $i,
                'category_id' => 1,
                'avatar_id' => rand(1, 2),
                'author_id' => 1,
                'ward_id' => 5,
                'district_id' => 2,
                'province_id' => 1,
                'price' => rand(50000, 2400000000),
                'attr' => json_encode(['material' => 'Gỗ']),
            ]);
        }


    }
}
