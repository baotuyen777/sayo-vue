<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PdwsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            ['id' => 1, 'name' => 'Hà Nội', 'code' => 'hn'],
            ['id' => 2, 'name' => 'Thanh Xuân', 'code' => 'hn-tx', 'parent_id' => 1],
            ['id' => 3, 'name' => 'Đống Đa', 'code' => 'hn-dd', 'parent_id' => 1],
            ['id' => 4, 'name' => 'TP. Hồ Chí Minh', 'code' => 'hcm'],
            ['name' => 'Thanh Xuân Bắc', 'code' => 'hn-tx-txb', 'parent_id' => 2],
            ['name' => 'Thanh Xuân Nam', 'code' => 'hn-tx-txn', 'parent_id' => 2],
            ['name' => 'Trung Văn', 'code' => 'hn-tx-tv', 'parent_id' => 2],
            ['name' => 'Nhân Chính', 'code' => 'hn-tx-nc', 'parent_id' => 2],
        ];
        foreach ($rows as $row) {
//            array_merge($row, ['content' => '', 'parent_id' => 0, 'user_id' => 1]);
            DB::table('pdws')->insert($row);
        }
    }
}
