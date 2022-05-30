<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\DropboxService;

class DropboxController extends Controller
{
    private $dropboxService;

    public function __construct()
    {
        $this->dropboxService = new DropboxService;
    }

    public function update_dropbox_photo_url()
    {
        if(time() >= env('UPDATE_DROPBOX_PHOTOS__url_EXPIRY')) {
            $this->dropboxService->refreshPhotoUrls();
        }
    }
}
