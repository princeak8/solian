<?php

namespace App\Services\Product;

use DB;
use Storage;
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
            $uploadedPhoto = Storage::disk('dropbox')->put('posts/featured_images', $file);
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
            // $rSize = $uploadedPhoto->getReadableSize(); // Get the size of the uploaded file in bytes, megabytes, gigabytes or terabytes. E.g 1.8 MB 
        }
        //dd('here6');
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