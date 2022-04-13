<?php

namespace App\Services\Product;

use DB;
use Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Photo;
use App\Models\Product;
use App\Models\File;
use App\Models\Collection;

use App\Services\Product\FileService;

class PhotoService
{

    private $fileService;

    public function __construct()
    {
        $this->fileService = new FileService;
    }

    public function allPhotos()
    {
        return Photo::all();
    }

    public function photos()
    {
        return Photo::where('deleted', '0')->orderBy('created_at', 'desc')->get();
    }

    public function unattachedPhotos()
    {
        return Photo::where('deleted', '0')->whereNull('product_id')->whereNull('collection_id')->where('slide', 0)->orderBy('created_at', 'desc')->get();
    }

    public function productPhotos()
    {
        return Photo::where('deleted', '0')->whereNotNull('product_id')->orderBy('created_at', 'desc')->get();
    }

    public function collectionPhotos()
    {
        return Photo::where('deleted', '0')->whereNotNull('collection_id')->orderBy('created_at', 'desc')->get();
    }

    public function slidePhotos()
    {
        return Photo::where('deleted', '0')->where('slide', 1)->orderBy('created_at', 'desc')->get();
    }

    public function photo($id)
    {
        return Photo::where('id', $id)->where('deleted', '0')->first();
    }

    public function productMain($product_id)
    {
        return Photo::where('product_id', $product_id)->where('main', 1)->first();
    }

    public function slides()
    {
        return Photo::where('slide', 1)->where('deleted', '0')->get();
    }

    public function collections()
    {
        return Photo::whereNotNull('collection_id')->where('deleted', '0')->get();
    }

    /*
        Saves multiple photos
        params: 
            $photos: Array of the photos to be uploaded
            $user_id: The Id of the user uploading
            $category: The category the photo belongs to as an array of the name and id of the category like product, collection, etc
    */
    public function savePhotos($photos, $user_id, $deleted_photos=[], $category=[])
    {
        foreach($photos as $p) {
            $photo = new Photo;
            $file_type = 'image';
            if(!in_array($p->getClientOriginalName(), $deleted_photos)) {
                //dd('here3');
                $file = $this->fileService->save($p, $file_type, $user_id);
                if($file && $file != null) {
                    $photo->file_id = $file->id;
                    if(!empty($category)) {
                        switch($category['name']) {
                            case 'product' : $photo->product_id = $category['id']; break;
                            case 'collection' : $photo->collection_id = $category['id']; break;
                        }
                    }
                }
                //dd('here2');
                $photo->save();
                //dd('here1');
            }
        }
        //dd('here');
    }

    public function changeProductMainPhoto($product, $photo)
    {
        $oldMain = $this->productMain($product->id);
        if(!$oldMain || ($oldMain && $oldMain->id != $photo->id)) {
            $photo->main = 1;
            $photo->update();
        }
        if($oldMain) {
            $oldMain->main = 0;
            $oldMain->update();
        }
    }

    public function delete($photo)
    {
        $photo->deleted = 1;
        $photo->update();
    }

    public function update_collections()
    {
        $collections = Collection::all();
        if($collections->count() > 0) {
           foreach($collections as $collection) {
               if(!empty($collection->photo)) {
                       $path = 'uploads/collections/'.$collection->photo;
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
                        $file->original_filename = $collection->photo;
                        $file->filename = $collection->photo;
                        $file->extension = $ext;
                        $file->size = $size;
                        $file->formatted_size = $formattedSize;
                        $file->url = $url;
                        $file->secure_url = $url;
                        $file->upload_date = $collection->created_at;
                        $file->height = $height;
                        $file->width = $width;
                        $file->save();
                        $photo = new Photo;
                        $photo->file_id = $file->id;
                        $photo->collection_id = $collection->id;
                        $photo->name = '';
                        $photo->save();
                        $collection->photo_id = $photo->id;
                        $collection->update();
               }
           } 
        }
        dd('done');
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