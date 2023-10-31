<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            'name' => 'Quản trị'
        ]);
        DB::table('departments')->insert([
            'name' => 'Nhân viên'
        ]);
        DB::table('departments')->insert([
            'name' => 'Khách hàng'
        ]);
    }
}
