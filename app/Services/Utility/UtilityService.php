<?php

namespace App\Services\Utility;

use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Helpers\Helper;
use Cloudinary;

use App\Models\Country;


class UtilityService
{

    public static function countries()
    {
        return Country::all();
    }
}

?>