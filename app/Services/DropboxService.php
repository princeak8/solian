<?php

namespace App\Services;

use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Helpers\Helper;
use Cloudinary;

use App\Models\Photo;

class DropboxService
{

    public static function refreshToken()
    {
        $res = Http::withBasicAuth(env('DROPBOX_APP_KEY'), env('DROPBOX_APP_SECRET'))->asForm()->post("https://api.dropboxapi.com/oauth2/token",[
            "refresh_token" => env('DROPBOX_REFRESH_TOKEN'),
            "grant_type"=>"refresh_token"
        ])->json();
        if(!isset($res['error']) && $res['access_token'] && !empty($res['access_token'])) {
            $res['expiry'] = $res['expires_in'] + time();
            // Helper::setEnvironmentValue('DROPBOX_AUTHORIZATION_TOKEN', $res['access_token']);
            // Helper::setEnvironmentValue('DROPBOX_TOKEN_EXPIRY', $res['expiry']);
            $envVars['DROPBOX_AUTHORIZATION_TOKEN'] = $res['access_token'];
            $envVars['DROPBOX_TOKEN_EXPIRY'] = $res['expiry'];
            Helper::setMultiEnvironmentValue($envVars);
        }else{
            \Log::stack(['project'])->info("Dropbox refresh token error: ".$res['error'].' : '.$res['error_description']);
        }
    }

    public static function refreshPhotoUrls()
    {
        $photos = Photo::all();
        if($photos->count() > 0) {
            foreach($photos as $photo) {
                
            }
        }
    }
}

?>