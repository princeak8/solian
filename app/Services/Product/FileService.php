<?php

namespace App\Services\Product;

use DB;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Models\Payment;
use App\Models\Order;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Order_status;
use App\Models\File;

use App\Helpers\Utility;
use Cloudinary;

use App\Services\Product\CollectionService;
use App\Services\Product\SizeService;

class FileService
{
    private $collectionService;

    public function __construct()
    {
        $this->collectionService = new CollectionService;
    }

    public function save($file, $file_type, $user_id)
    {
        $environment = env('ENVIRONMENT', 'local');
        $uploadedPhoto = null;
        $filename = '';
        $url = '';
        $secureUrl = '';
        if($environment=='local') {
            //dd('here4');
            $uploadedPhoto = Utility::UploadFile($file, 'products', $user_id);
            $filename = $uploadedPhoto->name;
            $url = env('APP_URL').$uploadedPhoto->file_url;
            $secureUrl = $url;
            $dimensions = getimagesize($uploadedPhoto->file_url);
            $width = $dimensions[0];
            $height = $dimensions[1];
            //dd('here5');
        }
        if($environment=='remote') {
            $uploadedPhoto = Storage::disk('dropbox')->put('posts', $file);
            $url = Storage::disk('dropbox')->url($uploadedPhoto);
            $secure_url = $url;
            $filename = $url;

            // $uploadedPhoto = $file->storeOnCloudinary('solian/products');
            // $filename = $uploadedPhoto->getFileName();
            // $url = $uploadedPhoto->getPath();
            // $secureUrl = $uploadedPhoto->getSecurePath();
            // $publicId = $uploadedPhoto->getPublicId();
            // $uploadDate = $uploadedPhoto->getTimeUploaded();
            // $width = $uploadedPhoto->getWidth(); 
            // $height = $uploadedPhoto->getHeight();
            // $size = $uploadedPhoto->getSize(); // Get the size of the uploaded file in bytes
            // $rSize = $uploadedPhoto->getReadableSize(); // Get the size of the uploaded file in bytes, megabytes, gigabytes or terabytes. E.g 1.5 MB
        }
        //dd('here6')
        dd($uploadedPhoto);
        if($uploadedPhoto && $uploadedPhoto != null) {
            $fileObj = new File;
            $fileObj->user_id = $user_id;
            $fileObj->file_type = $file_type;
            $fileObj->mime_type = $file->getClientMimeType();
            $fileObj->original_filename = $file->getClientOriginalName();
            $fileObj->extension = $file->getClientOriginalExtension();
            $fileObj->size = (isset($size)) ? $size : filesize($uploadedPhoto->file_url);
            $fileObj->formatted_size = (isset($rSize)) ? $rSize : $this->convertSize($fileObj->size);
            $fileObj->filename = $filename;
            $fileObj->url = $url;
            $fileObj->secure_url = $url;
            if(isset($publicId)) $fileObj->public_id = $publicId;
            $fileObj->width = $width;
            $fileObj->height = $height;
            $fileObj->save();
            //dd('here7');
            
        }
        //dd('here8');
        return (isset($fileObj)) ? $fileObj : null;
    }

    public function addDropBoxPhotos($photos, $user_id, $category) 
    {
        $fileIds = [];
        foreach($photos as $photo) {
            $fileIds[] = $this->addDropBoxPhoto($photo, $user_id, $category);
        }
        return $fileIds;
    }

    public function addDropBoxPhoto($photo, $user_id, $category)
    {
        $fileObj = new File;
        if($category == 'collection' && !empty($photo['collection_id'])) {
            $collection = $this->collectionService->collection($photo['collection_id']);
            if($collection->photo->file) $fileObj = $collection->photo->file;
        }
        
        $fileObj->thumb = $photo['thumb'];
        $fileObj->path = $photo['file'];
        $fileObj->user_id = $user_id;
        $fileObj->url = $photo['url'];
        $fileObj->secure_url = $fileObj->url;
        $fileObj->file_type = 'image';
        $filePathParts = pathinfo($photo['file']);
        // $dimension = getimagesize($fileObj->url);
        $fileObj->extension = $filePathParts['extension'];
        $fileObj->filename = $filePathParts['basename'];
        // $fileObj->width = $dimension[0];
        // $fileObj->height = $dimension[1];
        // $fileObj->mime_type = $dimension['mime'];
        $fileObj->file_type = 'image';
        $fileObj->size = $photo['size'];
        $fileObj->formatted_size = $this->convertSize($fileObj->size);
        //dd($fileObj);
        $fileObj->save();
        if($category == 'product') {
            if(session('dropBoxProductPhotos') != null && count(session('dropBoxProductPhotos')) > 0) {
                $sessiondropBoxProductPhotos = [];
                foreach(session('dropBoxProductPhotos') as $sessionPhotos) {
                    foreach($sessionPhotos as $key=>$sessionPhoto) {
                        //dd($sessionPhoto->file);
                        if($sessionPhoto->file == $photo['file']) {
                            //dd($sessionPhotos[$key]);
                            unset($sessionPhotos[$key]);
                        }
                    }
                    $sessiondropBoxProductPhotos[] = $sessionPhotos;
                }
                session(['dropBoxProductPhotos' => $sessiondropBoxProductPhotos]);
            }
        }
        return $fileObj->id;
    }

    private function convertSize($size)
    {
        $formatted = '';
        $len = strlen($size);
        if($len < 4) $formatted = $size.'Bytes'; 
        if($len > 3 && $len < 7) $formatted = round((float)($size/1024), 1).'KB';
        if($len > 6 && $len < 11) $formatted = round((float)(($size/1024)/1024), 1).'MB';
        if($len > 10 && $len < 14) $formatted = round((float)((($size/1024)/1024)/1024), 1).'GB';
        //return (float)$formatted;
        return $formatted;
    }
}

?>