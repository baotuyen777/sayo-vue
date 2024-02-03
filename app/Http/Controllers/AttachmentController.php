<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Flysystem\Filesystem;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;

class AttachmentController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // Adjust the allowed file types and size
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = 'attachments/' . $fileName;

        $adapter = new AwsS3V3Adapter(new \Aws\S3\S3Client([
            'credentials' => [
                'key' => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret'),
            ],
            'region' => config('filesystems.disks.s3.region'),
            'version' => 'latest',
        ]), config('filesystems.disks.s3.bucket'));

        $filesystem = new Filesystem($adapter);

        $filesystem->write($filePath, file_get_contents($file));

        // Save attachment information in the database if needed

        return response()->json(['message' => 'Attachment uploaded successfully']);
    }

    public function delete($fileName)
    {
        $filePath = 'attachments/' . $fileName;

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

            return response()->json(['message' => 'Attachment deleted successfully']);
        } else {
            return response()->json(['error' => 'Attachment not found'], 404);
        }
    }
}
