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
            $uploadedPhoto = Utility::UploadFile($p, 'products', Auth::user()->id);
            $filename = $uploadedPhoto->name;
            $url = $uploadedPhoto->file_url;
            $secureUrl = $url;
            $dimensions = getimagesize($p);
            $width = $dimension[0];
            $height = $dimension[1];
        }
        if($environment=='remote') {
            $uploadedPhoto = $p->storeOnCloudinary('solian/products');
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
            $file = new File;
            $file->user_id = $user__id;
            $file->file_type = $file_type;
            $file->mime_type = $file->getClientMimeType();
            $file->original_filename = $file->getClientOriginalName();
            $file->extension = $file->getClientOriginalExtension();
            $file->size = (isset($size)) ? $size : filesize($file);
            $file->formatted_size = (isset($rSize)) ? $rSize : $this->convertSize($file->size);
            $file->filename = $filename;
            $file->url = $url;
            $file->secure_url = $url;
            if(isset($publicId)) $file->public_id = $publicId;
            $file->width = $width;
            $file->height = $height;
            $file->save();
            
        }
        return (isset($file)) ? $file : null;
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