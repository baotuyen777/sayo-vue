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
            'name' => 'abc',
            'code' => 'code1',
            'value' => 'value1',
        ]);
        DB::table('settings')->insert([
            'name' => 'abc2',
            'code' => 'code2',
            'value' => 'value2',
        ]);

    }
}
