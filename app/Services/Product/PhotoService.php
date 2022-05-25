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

    public function slidesAsFiles()
    {
        $arr = [];
        $slides = $this->slides();
        if($slides->count() > 0) {
            foreach($slides as $slide) {
                if($slide->file) $arr[$slide->file->path] = $slide;
            }
        }
        return $arr;
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

    public function addPhotosToCategory($fileIds, $category, $id=null)
    {
        foreach($fileIds as $file_id) {
            $this->addPhotoToCategory($file_id, $category, $id);
        }
        
    }

    public function addPhotoToCategory($file_id, $category, $id=null)
    {
        $photo = new Photo;
        $photo->file_id = $file_id;
        if($category=='product') $photo->product_id = $id;
        if($category=='collection') $photo->collection_id = $id;
        if($category=='slide') $photo->slide = 1;
        $photo->save();
        
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
        $photo->delete();
    }

    public function getDropboxProductPhotos($page=1, $force=false)
    {
        $dropBoxProductPhotosArr = [];
        if(!$force && (time() < env('FETCH_DROPBOX_PRODUCT_PHOTOS_EXPIRY') && session('dropBoxProductPhotos') != null)) {
            // dd('here1');
            foreach(session('dropBoxProductPhotos')[$page-1] as $photo) $dropBoxProductPhotosArr[] = $photo;
        }else{
            // dd('here2');
            $dropBoxProductPhotosArr = $this->getDropboxPhotos('product', $page);
            session(['dropBoxProductPhotos' => null]);
            if(session('dropBoxProductPhotos') == null) session(['dropBoxProductPhotos' => []]);
                //session(['dropBoxProductPhotos' => $dropBoxProductPhotos]);
            $sessionDropBoxProductPhotos = session('dropBoxProductPhotos');
            $sessionDropBoxProductPhotos[$page-1] = $dropBoxProductPhotosArr;
            session(['dropBoxProductPhotos' => $sessionDropBoxProductPhotos]);
            Helper::setEnvironmentValue('FETCH_DROPBOX_PRODUCT_PHOTOS_EXPIRY', (time() + (60*30)));
        }
        return $dropBoxProductPhotosArr;
    }

    public function getDropboxCollectionPhotos($force=false)
    {
        $dropBoxCollectionPhotosArr = [];
        if(!$force && (time() < env('FETCH_DROPBOX_COLLECTION_PHOTOS_EXPIRY') && session('dropBoxCollectionPhotos') != null)) {
            foreach(session('dropBoxCollectionPhotos') as $photo) $dropBoxCollectionPhotosArr[] = $photo;
        }else{
            $dropBoxCollectionPhotosArr = $this->getDropboxPhotos('collection');
            session(['dropBoxCollectionPhotos' => null]);
            if(session('dropBoxCollectionPhotos') == null) session(['dropBoxCollectionPhotos' => []]);
                //session(['dropBoxCollectionPhotos' => $dropBoxCollectionPhotos]);
            $sessionDropBoxCollectionPhotos = session('dropBoxCollectionPhotos');
            $sessionDropBoxCollectionPhotos = $dropBoxCollectionPhotosArr;
            session(['dropBoxCollectionPhotos' => $sessionDropBoxCollectionPhotos]);
            Helper::setEnvironmentValue('FETCH_DROPBOX_COLLECTION_PHOTOS_EXPIRY', (time() + (60*30)));
        }
        return $dropBoxCollectionPhotosArr;
    }

    public function getDropboxSlidePhotos($force=false)
    {
        $dropBoxSlidePhotosArr = [];
        if(!$force && (time() < env('FETCH_DROPBOX_SLIDE_PHOTOS_EXPIRY') && session('dropBoxSlidePhotos') != null)) {
            foreach(session('dropBoxSlidePhotos') as $photo) $dropBoxSlidePhotosArr[] = $photo;
        }else{
            $dropBoxSlidePhotosArr = $this->getDropboxPhotos('slide');
            session(['dropBoxSlidePhotos' => null]);
            if(session('dropBoxSlidePhotos') == null) session(['dropBoxSlidePhotos' => []]);
            $sessionDropBoxSlidePhotos = session('dropBoxSlidePhotos');
            $sessionDropBoxSlidePhotos = $dropBoxSlidePhotosArr;
            session(['dropBoxSlidePhotos' => $sessionDropBoxSlidePhotos]);
            Helper::setEnvironmentValue('FETCH_DROPBOX_SLIDE_PHOTOS_EXPIRY', (time() + (60*30)));
        }
        return $dropBoxSlidePhotosArr;
    }

    private function getCategoryFolder($category)
    {
        switch($category) {
            case 'product'      :  $folder = 'web/products'; break;
            case 'collection'   :  $folder = 'web/collections'; break;
            case 'slide'       :  $folder = 'web/slides'; break;
            default: $folder = 'web'; break;
        }
        return $folder;
    }

    private function getDropboxPhotos($category, $page=1)
    {
        $folder = $this->getCategoryFolder($category);
        $dropBoxPhotos = [];
        $files = Storage::disk('dropbox')->files($folder);
        //dd($files);
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
            //dd($entries);
            $thumbs = $this->_handle_getting_thumbnails($entries);
                //dd($thumbs);
            if($thumbs != null) {
                $paths = [];
                    //dd('success');
                if(count($thumbs['entries']) > 0) {
                    foreach($thumbs['entries'] as $thumb) {
                        $f = new stdClass();
                        $f->thumb = 'data:image/jpg;base64,'.$thumb['thumbnail'];
                        $arr = explode('/', $thumb['metadata']['path_lower']);
                        array_shift($arr);
                        $path = implode('/', $arr);
                        $paths[] = $path;
                        $f->file = $path;
                        $f->url = Storage::disk('dropbox')->url($path);
                        $f->size = Storage::disk('dropbox')->size($path);
                        $dropBoxPhotos[] = $f;
                    }
                    if($category=='product') $dropBoxPhotos = $this->filter_dropbox_photos($paths, $dropBoxPhotos);
                }
            }else{
                $msg = '';
                throw new \Exception("Error attempting to get thumbnails, verify request payload");
            }
        }
        $dropBoxPhotosArr = [];
        if(count($dropBoxPhotos) > 0) {
            foreach($dropBoxPhotos as $photo) $dropBoxPhotosArr[] = $photo;
        }
        return $dropBoxPhotosArr;
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

    /*
        filter photos into new ones that needs to be added and ones that needs to be deleted
        $photos = The photos array sent via the post request
        $currSlides = the current slides in the database
        $paths = an array where the file path of the slide photos that are in the database will be stored
        $pathPhotos = an array of key value pairs where the file path of the slide photos that are in the database will be stored with the file path as key and the photo obj as value

    */
    public function filter_slide_photos($photos)
    {
        //Get slide photos from the database
        $currSlides = $this->slidePhotos();
        $paths = [];
        $pathPhotos = [];
        if($currSlides->count() > 0) {
            foreach($currSlides as $slide) {
                if($slide->file) {
                    $paths[] = $slide->file->path;
                    $pathPhotos[$slide->file->path] = $slide;
                }
            }
        }
        foreach($photos as $key=>$photo) {
            if(in_array($photo['file'], $paths)) {
                //The photo exists in the database, so no need to add it again
                unset($photos[$key]);
                $key2 = array_search($photo['file'], $paths);
                unset($paths[$key2]);
            }
        }

        //delete any deactivated slides
        if(count($paths) > 0) {
            foreach($paths as $path) $pathPhotos[$path]->delete();
        }
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