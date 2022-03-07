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

class ProductService
{

    public function allProducts()
    {
        return Product::all();
    }

    public function products()
    {
        return Product::where('deleted', '0')->orderBy('created_at', 'desc')->get();
    }

    public function product($id)
    {
        return Product::where('id', $id)->where('deleted', '0')->first();
    }

    public function update()
    {
        $products = $this->products();
        if($products->count() > 0) {
           foreach($products as $product) {
               if($product->photos->count() > 0) {
                   foreach($product->photos as $photo) {
                       $path = 'uploads/products/'.$photo->name;
                       //dd(asset('uploads/products/'.$photo->name));
                        $filePathParts = pathinfo(asset($path));
                        $dimension = getimagesize($path);
                        $width = $dimension[0];
                        $height = $dimension[1];
                        $mime = $dimension['mime'];
                        $size = filesize($path);
                        $formattedSize = $this->convertSize($size);
                        $type = 'image';
                        $url = $filePathParts['dirname'].'/'.$filePathParts['basename'];
                        $ext = $filePathParts['extension'];
                        // dd($dimension);
                        // dd($type);
                        $file = new File;
                        $file->user_id = 2;
                        $file->file_type = $type;
                        $file->mime_type = $mime;
                        $file->original_filename = $photo->name;
                        $file->filename = $photo->name;
                        $file->extension = $ext;
                        $file->size = $size;
                        $file->formatted_size = $formattedSize;
                        $file->url = $url;
                        $file->secure_url = $url;
                        $file->upload_date = $photo->created_at;
                        $file->height = $height;
                        $file->width = $width;
                        $file->save();
                        $photo->file_id = $file->id;
                        
                        $photo->update();
                        
                   }
               }
           } 
        }
        dd('done');
        $environment = env('ENVIRONMENT', 'local');
        $url = asset('uploads/products/thumbnails/'.$product->main);
        if(isset($data['name'])) $product->name = $data['name'];
        if(isset($data['quantity'])) $product->quantity = $data['quantity'];
        if(isset($data['price'])) $product->price = $data['price'];
        if(isset($data['description'])) $product->description = $data['description']; 
        $product->update();
        dd($environment);
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

    //public function updatePhoto($file, $photo)
}

?>