<?php

namespace App\Services;

use App\Models\Files;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;

class FileService
{
    public $context;

    public function upload(Request $request)
    {
//        $request->validate([
//            'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // Adjust the allowed file types and size
//        ]);
        $adapter = new AwsS3V3Adapter(new \Aws\S3\S3Client([
            'credentials' => [
                'key' => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret'),
            ],
            'region' => config('filesystems.disks.s3.region'),
            'version' => 'latest',
        ]), config('filesystems.disks.s3.bucket'));

        $objs = [];
        if ($request->has('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $name = time() . '_' . $file->getClientOriginalName();
                $filePath = 'product/' . $name;

                $filesystem = new Filesystem($adapter);

                $filesystem->write($filePath, file_get_contents($file));
                $params = [
                    'name' => $name,
                    'url' => $filePath
                ];
                $file = Files::create($params);
                $file->url_full = asset('storage/' . $file->url);
                $objs[] = $file;
            }
        }
//        $ids = array_column($objs, 'id');
        return $objs;
//        $file = $request->file('file');
//        $fileName = time() . '_' . $file->getClientOriginalName();
//        $filePath = 'attachments/' . $fileName;
//
//        $filesystem = new Filesystem($adapter);
//
//        $filesystem->write($filePath, file_get_contents($file));
//
//        // Save attachment information in the database if needed
//
//        return response()->json(['message' => 'Attachment uploaded successfully']);
    }

    public function delete($fileName)
    {
        $filePath = 'product/' . $fileName;

        $adapter = new AwsS3V3Adapter(new \Aws\S3\S3Client([
            'credentials' => [
                'key' => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret'),
            ],
            'region' => config('filesystems.disks.s3.region'),
            'version' => 'latest',
        ]), config('filesystems.disks.s3.bucket'));

        $filesystem = new Filesystem($adapter);

        if ($filesystem->has($filePath)) {
            $filesystem->delete($filePath);

            // Remove attachment information from the database if needed
            return true;
//            return response()->json(['message' => 'Attachment deleted successfully']);
        } else {
            return false;
//            return response()->json(['error' => 'Attachment not found'], 404);
        }
    }

    public function getImage($fileName)
    {
        $filePath = 'product/' . $fileName;

        $adapter = new AwsS3V3Adapter(new \Aws\S3\S3Client([
            'credentials' => [
                'key' => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret'),
            ],
            'region' => config('filesystems.disks.s3.region'),
            'version' => 'latest',
        ]), config('filesystems.disks.s3.bucket'));

        $filesystem = new Filesystem($adapter);

        if ($filesystem->has($filePath)) {
            $image = $filesystem->read($filePath);
            return $image;
//            return response($image, 200)->header('Content-Type', 'image/jpeg');
        } else {
            return false;
//            return response()->json(['error' => 'Image not found'], 404);
        }
    }
}
