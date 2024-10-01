<?php

namespace App\Http\Controllers\Admin;

use App\Models\Files;
use App\Services\BaseService;
use App\Services\FileService;
use Illuminate\Http\Request;

class FileController extends CommonController
{
    protected string $module = 'files';

    public function __construct(
        BaseService                  $baseService,
        private readonly FileService $fileService
    )
    {
        parent::__construct($baseService);
    }

    public function store(Request $request)
    {
//        $currentDate = date('Y-m-d');
//        $folderPath = 'public/uploads/' . $currentDate;
//
//        if ($request->hasfile('files')) {
//            $res = [];
//            $files = $request->file('files');
//
//            foreach ($files as $file) {
//                $name = $file->getClientOriginalName();
//                $storePath = $file->storeAs($folderPath, $name);
//                $params = [
//                    'name' => $name,
//                    'url' => str_replace('public/', '', $storePath)
//                ];
//                $file = Files::create($params);
//                $file->url_full = asset('storage/' . $file->url);
//                $res[] = $file;
//            }
//        }
//        $ids = array_column($res, 'id');
        $res = $this->fileService->upload($request);
        $ids = array_column($res, 'id');
        return response()->json(['status' => true, 'result' => $res, 'ids' => $ids]);
    }

//    public function posts()
//    {
//        return $this->belongsToMany()
//    }

//    public function posts(): MorphToMany
//    {
//        return $this->morphedByMany(Posts::class,'files1');
//    }

    public function show(string $id)
    {
        $
        $image = $this->fileService->getImage($id);
        if ($image) {
            return response($image, 200)->header('Content-Type', 'image/jpeg');
        } else {
            return response()->json(['error' => 'Image not found'], 404);
        }
    }
}
