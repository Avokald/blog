<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class UploadHelper extends Facade {
    protected static function getFacadeAccessor(){
        return \App\Helpers\UploadHelper::class;
    }
}
