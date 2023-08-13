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
        $prices = [135000,4560000000, 740000,180000000];
        for ($i = 1; $i < 10; $i++) {

            DB::table('posts')->insert([
                'name' => $faker->name. $faker->name.$faker->name.$faker->name.$faker->name.'__' . $i,
                'code' => 'code ' . $i,
                'content' => 'value ' . $i,
                'category_id' => 1,
                'avatar_id' => rand(1,2),
                'user_id' => 1,
                'ward_id' => 5,
                'district_id' => 2,
                'province_id' => 1,
                'price' => $prices[array_rand($prices)]
            ]);
        }


    }
}
