<?php

namespace App\Services\Product;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use stdClass;
use session;
use Illuminate\Support\Facades\Http;

use App\Models\Photo;
use App\Models\Product;
use App\Models\File;
use App\Models\Collection;

use App\Services\Product\FileService;

use App\Helpers\Helper;

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

    public function attachedPhotos()
    {
        return Photo::whereNotNull('product_id')->orWhereNotNull('collection_id')->orWhere('slide', 1)->orderBy('created_at', 'desc')->get();
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
                dd($file);
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

    public function addPhotosToCategory($fileIds, $id, $category)
    {
        foreach($fileIds as $file_id) {
            $photo = new Photo;
            $photo->file_id = $file_id;
            if($category=='product') $photo->product_id = $id;
            if($category=='collection') $photo->collection_id = $id;
            if($category=='slide') $photo->slide = 10.;
            $photo->save();
        }
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

    public function getDropboxPhotos($page=1)
    {
        if(time() < env('FETCH_DROPBOX_PHOTOS_EXPIRY') && session('dropBoxPhotos') != null) {
            return session('dropBoxPhotos')[$page-1];
        }else{
            $dropBoxPhotos = [];
            $files = Storage::disk('dropbox')->files('web');
            $entries = [];
            $start = ($page-1) * 24;
            $end = $start + 24;
            $max = (count($files) > $end) ? $end : count($files);
            for($i=$start; $i<$max; $i++) {
                $e = new stdClass();

                $e->format = "jpeg";
                $e->mode = "strict";
                $e->path = "/".$files[$i];
                $e->size = env("DROPBOX_THUMBNAIL_SIZE", "w640h480");
                $entries[] = $e;
            } 
            $thumbs = [];
            if(count($entries) > 0) {
                $thumbs = $this->_handle_getting_thumbnails($entries);
                //dd($thumbs);
                if($thumbs != null) {
                    $paths = [];
                    //dd('success');
                    if(count($thumbs['entries']) > 0) {
                        $th = $thumbs['entries'];
                        //dd($dropBoxPhotos);
                        foreach($thumbs['entries'] as $thumb) {
                            $f = new stdClass();
                            $f->thumb = $thumb['thumbnail'];
                            $arr = explode('/', $thumb['metadata']['path_lower']);
                            array_shift($arr);
                            $path = implode('/', $arr);
                            $paths[] = $path;
                            $f->file = $path;
                            $f->url = Storage::disk('dropbox')->url($path);
                            $f->size = Storage::disk('dropbox')->size($path);
                            $dropBoxPhotos[] = $f;
                        }
                        $dropBoxPhotos = $this->filter_dropbox_photos($paths, $dropBoxPhotos);
                    }
                }else{
                    //dd('fail');
                    $msg = '';
                    //foreach($entries as $e)
                    throw new \Exception("Error attempting to get thumbnails, verify request payload");
                }
            }
            $dropBoxPhotosArr = [];
            if(count($dropBoxPhotos) > 0) {
                foreach($dropBoxPhotos as $photo) $dropBoxPhotosArr[] = $photo;
            }
            //dd($dropBoxPhotos);
            session(['dropBoxPhotos' => null]);
            if(session('dropBoxPhotos') == null) session(['dropBoxPhotos' => []]);
            //session(['dropBoxPhotos' => $dropBoxPhotos]);
            $sessionDropboxPhotos = session('dropBoxPhotos');
            $sessionDropboxPhotos[$page-1] = $dropBoxPhotosArr;
            session(['dropBoxPhotos' => $sessionDropboxPhotos]);
            //dd(session('dropBoxPhotos'));

            Helper::setEnvironmentValue('FETCH_DROPBOX_PHOTOS_EXPIRY', (time() + (60*30)));
            
            return $dropBoxPhotosArr;
        }
    }

    private function _handle_getting_thumbnails($entries)
    {
        return $this->getThumbnails($entries);
    }
    /*
        Filter photos from dropbox to remove those that has been attached to a product, collection or slide
    */
    public function filter_dropbox_photos($paths, $photos)
    {
        $attachedPhotos = $this->attachedPhotos();
        if($attachedPhotos->count() > 0) {
            foreach($attachedPhotos as $attachedPhoto) {
                if($attachedPhoto->file && in_array($attachedPhoto->file->path, $paths)) {
                    //dd($attachedPhoto->file->path);
                    $photos = $this->remove_from_dropbox_photos($attachedPhoto->file->path, $photos);
                    //dd($photos);
                }
            }
        }
        //dd($photos);
        return $photos;
    }

    private function remove_from_dropbox_photos($path, $dropBoxPhotos)
    {
        foreach($dropBoxPhotos as $key=>$photo) {
            if($photo->file == $path) {
                unset($dropBoxPhotos[$key]);
            }
        }
        return $dropBoxPhotos;
    }

    public function getThumbnails($entries)
    {
        $res = Http::withHeaders([
            "Authorization" => "Bearer ".env('DROPBOX_AUTHORIZATION_TOKEN'),
            "Content-Type" => "application/json"
        ])->post("https://content.dropboxapi.com/2/files/get_thumbnail_batch",[
            "entries" => $entries
        ])->json();
        return $res;
    }

    //public function updatePhoto($file, $photo)
}

?>