<?php

namespace App\Http\Controllers;

use App\Models\Medias;
use App\Models\Posts;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediasController extends Controller
{
    protected string $module = 'medias';

    public function store(Request $request)
    {
        $image = $request->file('file');

        $imageName = $image->getClientOriginalName();
        $currentDate = date('Y-m-d');
        $folderPath = 'uploads/' . $currentDate;

//        $image->move(public_path($folderPath), $imageName);
        $storePath = $image->storeAs($folderPath, $imageName, 'public');
        $media = new Medias();
        $media->name = $imageName;
        $media->url = $storePath;
        $media->save();

        return response()->json(['status' => true, 'result' => $media]);
    }

//    public function posts()
//    {
//        return $this->belongsToMany()
//    }

//    public function posts(): MorphToMany
//    {
//        return $this->morphedByMany(Posts::class,'medias1');
//    }
}
