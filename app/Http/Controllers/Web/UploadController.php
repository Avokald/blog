<?php

namespace App\Http\Controllers\Web;

use App\Facades\UploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function __construct()
    {
    }

    const IMAGE_PATH_NAME = 'upload.image';
    public function image(Request $request)
    {
        if ($request->hasFile('file')) {
            $url = UploadHelper::uploadImage($request->file('file'));
            return response()->json([
                'url' => $url
            ]);
        }
        return response()->json(['error' => true]);
    }

    const FILE_PATH_NAME = 'upload.file';
    public function file(Request $request)
    {
        if ($request->hasFile('file')) {
            $url = UploadHelper::uploadFile($request->file('file'));
            return response()->json([
                'url' => $url
            ]);
        }
        return response()->json(['error' => true]);
    }
}

