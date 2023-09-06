<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class FilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('files')->insert(['name' => 1, 'url' => 'uploads/demo/bds1.jpg']);
        DB::table('files')->insert(['name' => 2, 'url' => 'uploads/demo/bds2.jpg']);
        DB::table('files')->insert(['name' => 3, 'url' => 'uploads/demo/bds3.jpg']);
        DB::table('files')->insert(['name' => 4, 'url' => 'uploads/demo/bds4.jpg']);

    }
}
