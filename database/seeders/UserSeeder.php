<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
            'username' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'departments_id' => 1,
            'status_id' => 1,
            'role' => 1,
        ]);

        DB::table('users')->insert([
            'username' => 'nva',
            'name' => 'Nguyễn Văn A',
            'email' => 'nva@gmail.com',
            'password' => Hash::make('123456'),
            'departments_id' => 1,
            'status_id' => 1,
            'role' => 2,
        ]);

        DB::table('users')->insert([
            'username' => 'shoptretho',
            'name' => 'Shop tre tho',
            'email' => 'stt@gmail.com',
            'password' => Hash::make('123456'),
            'departments_id' => 1,
            'status_id' => 1,
            'role' => 3,
        ]);
    }
}
