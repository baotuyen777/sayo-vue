<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            'name' => 'setting1',
            'code' => 'setting',
            'value' => 'value1',
        ]);
        DB::table('settings')->insert([
            'name' => 'setting2',
            'code' => 'setting2',
            'value' => 'value2',
        ]);

    }
}
