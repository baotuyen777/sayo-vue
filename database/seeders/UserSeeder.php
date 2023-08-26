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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('users')->insert([
            'username' => 'admin',
            'phone' => '0394045475',
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'departments_id' => 1,
            'status' => 1,
            'role' => 1,
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
        ]);

        DB::table('users')->insert([
            'username' => 'shoptretho',
            'phone' => '0394045477',
            'name' => 'Shop tre tho',
            'email' => 'stt@gmail.com',
            'password' => Hash::make('123456'),
            'departments_id' => 1,
            'status' => 1,
            'role' => 3,
        ]);
    }
}
