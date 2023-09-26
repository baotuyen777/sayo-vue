<?php

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;

class ImportNews implements WithHeadingRow, SkipsOnFailure, ToModel, WithChunkReading
{
    public function onFailure(Failure ...$failures)
    {

    }

    public function model(array $row)
    {
        if($row['name']){
            return new News($row);
        }
//        return new News([
//            'name' => $row[1],
//            'code' => $row[2],
//            'content' => $row[3],
//            'content' => $row[3],
//            'category_id' => $row[4],
//            'avatar_link' => $row[5],
//            'author' => $row[6] ?? 1,
//        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }


}
