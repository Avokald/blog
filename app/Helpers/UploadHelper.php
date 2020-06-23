<?php

namespace App\Helpers;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;

class UploadHelper {

    private $path;
    private $fileName;

    function __construct() {
        $random = md5(microtime());
        $this->path = 'uploads/' . substr($random, 0, 2) . '/' . substr($random, 2, 2) . '/';
        if (!Storage::disk('uploads')->has($this->path)) {
            Storage::disk('uploads')->makeDirectory($this->path);
        }
        $this->fileName = substr($random, 4) . '.';
    }

    public function uploadProductImage($image, $newWidth = null, $newHeight = null) {
        $path = 'uploads/products/';

        $filename = Storage::url($image);

        $image_resize = File::copy($filename, $path.'2123.jpg');

        if ($newWidth && $newHeight) {
            $image_resize->fit($newWidth, $newHeight);
        }

        $image_resize->save(public_path($path .$filename));

        return URL::to('/') . '/' . $path . $filename;
    }


    public function uploadImage($image, $newWidth = null, $newHeight = null) {
        $filename = preg_replace('~\s~', '',  $this->fileName . mb_strtolower($image->getClientOriginalExtension()));
        $image_resize = Image::make($image->getRealPath());

        if ($newWidth && $newHeight) {
            $image_resize->fit($newWidth, $newHeight);
        }

        $image_resize->save(public_path($this->path .$filename));

        return URL::to('/') . '/' . $this->path . $filename;
    }

    public function uploadImageByUrl($url, $newWidth = null, $newHeight = null) {
        if ($url) {
            $filename = substr(md5(microtime()), -6) . '.jpg';
            $image_resize = Image::make($url);

            if ($newWidth && $newHeight) {
                $image_resize->fit($newWidth, $newHeight);
            }

            $image_resize->save(public_path($this->path .$filename));

            return URL::to('/') . '/' . $this->path . $filename;
        }
        return null;
    }

    public function uploadFile($file) {
        $filename = preg_replace('~\s~', '', $this->fileName . mb_strtolower($file->getClientOriginalExtension()));

        $file->move($this->path, $filename);

        return URL::to('/') . '/' . $this->path . $filename;
    }
}

