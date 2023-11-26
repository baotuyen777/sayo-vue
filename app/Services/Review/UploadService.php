<?php

namespace App\Services\Review;

use App\Models\Files;

class UploadService
{
    public function uploadFile($request)
    {
        $currentDate = date('Y-m-d');
        $folderPath = 'public/uploads/' . $currentDate;

        if ($request->hasfile('files')) {
            $res = [];
            $files = $request->file('files');

            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $storePath = $file->storeAs($folderPath, $name);
                $params = [
                    'name' => $name,
                    'url' => str_replace('public/', '', $storePath)
                ];
                $file = Files::create($params);
                $file->url_full = asset('storage/' . $file->url);
                $res[] = $file;
            }
        }
        $urls = array_column($res, 'url');

        return $urls;
    }
}
