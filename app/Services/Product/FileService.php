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
            $uploadedPhoto = Utility::UploadFile($file, 'products', Auth::user()->id);
            $filename = $uploadedPhoto->name;
            $url = env('APP_URL').$uploadedPhoto->file_url;
            $secureUrl = $url;
            $dimensions = getimagesize($uploadedPhoto->file_url);
            $width = $dimensions[0];
            $height = $dimensions[1];
        }
        if($environment=='remote') {
            $uploadedPhoto = $file->storeOnCloudinary('solian/products');
            $filename = $uploadedPhoto->getFileName();
            $url = $uploadedPhoto->getPath();
            $secureUrl = $uploadedPhoto->getSecurePath();
            $publicId = $uploadedPhoto->getPublicId();
            $uploadDate = $uploadedPhoto->getTimeUploaded();
            $width = $uploadedPhoto->getWidth(); 
            $height = $uploadedPhoto->getHeight();
            $size = $result->getSize(); // Get the size of the uploaded file in bytes
            $rSize = $result->getReadableSize(); // Get the size of the uploaded file in bytes, megabytes, gigabytes or terabytes. E.g 1.8 MB 
        }
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
            
        }
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