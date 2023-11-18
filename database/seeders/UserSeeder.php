<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('users')->insert([
            'username' => 'admin',
            'phone' => '0394045475',
            'name' => 'Bùi Nguyễn Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'departments_id' => 1,
            'status' => 2,
            'role' => 1,
//            'avatar_id' => 1,
            'created_at'=> Carbon::now(),
            'province_id'=>1,
            'district_id'=>1,
            'ward_id'=>1,
        ]);

        DB::table('users')->insert([
            'username' => 'nva',
            'phone' => '0394045476',
            'name' => 'Nguyễn Văn A',
            'email' => 'nva@gmail.com',
            'password' => Hash::make('123456'),
            'departments_id' => 1,
            'status' => 1,
            'role' => 2,
//            'avatar_id' => 1,
            'created_at'=> Carbon::now(),
            'province_id'=>2,
            'district_id'=>2,
            'ward_id'=>2,
        ]);

        DB::table('users')->insert([
            'username' => 'shoptretho',
            'phone' => '0394045477',
            'name' => 'Shop tre tho',
            'email' => 'stt@gmail.com',
            'password' => Hash::make('123456'),
            'departments_id' => 1,
            'status' => 2,
            'role' => 3,
//            'avatar_id' => 1,
            'created_at'=> Carbon::now(),
            'province_id'=>3,
            'district_id'=>3,
            'ward_id'=>3,
        ]);
    }
}
