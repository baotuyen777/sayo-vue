<?php
namespace App\Exports;

use App\Models\News;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class NewsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return News::all();
    }
    //Thêm hàng tiêu đề cho bảng
    public function headings() :array {
        return ["stt", "name", "code", "content",'category_id','avatar_link','author_id'];
    }
}
