<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Napp\Xray\Facades\Xray;
// use Napp\Xray\Facades\Xray;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        
        Xray::addSegment('MyCustomLogic');

        $request->validate([
            'file' => 'required|mimes:jpeg,png,pdf|max:2048', // Adjust the allowed file types and size as needed
        ]);

        if ($request->file('file')->isValid()) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();

            // Get the path of the uploaded file
            $sourceFilePath = $file->getRealPath();


            // Create S3 client
            $s3 = \App::make('aws')->createClient('s3');

            try {
                $result = $s3->putObject([
                    'Bucket' => env('AWS_BUCKET'),
                    'Key' => $fileName,
                    'SourceFile' => $sourceFilePath,
                ]);
            } catch (\Aws\S3\Exception\S3Exception $e) {
                // Catch any S3 exceptions and return an error message
                return redirect()->back()->with('error', 'Failed to upload the file to S3: ' . $e->getMessage());
            }

            $url = $result['ObjectURL'];
            // run your code

              Xray::endSegment('MyCustomLogic');

            return redirect()->back()->with('success', 'File uploaded successfully. File path: ' . $url);
        }

        return redirect()->back()->with('error', 'Failed to upload the file.');
    }
}