<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\DropboxService;
use App\Services\Product\PhotoService;

class DropboxController extends Controller
{
    private $photoService;

    public function __construct()
    {
        $this->photoService = new PhotoService;
    }

    public function refresh_token()
    {
        if(time() > env('DROPBOX_TOKEN_EXPIRY') || ((env('DROPBOX_TOKEN_EXPIRY') - time()) <= 60)) {
            //dd(time().' < '.env('DROPBOX_TOKEN_EXPIRY'));
            //If the dropbox token has expired or will expire in less than 1minute
            try{ 
                DropboxService::refreshToken();
            }catch(\Throwable $th) {
                \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            }
        }
    }

    public function fetch_photos()
    {
        $this->photoService->getDropboxProductPhotos(1, true);
        $this->photoService->getDropboxCollectionPhotos(true);
        $this->photoService->getDropboxSlidePhotos(true);
    }
}
