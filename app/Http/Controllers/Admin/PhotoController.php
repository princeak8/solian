<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use stdClass;

use Intervention\Image\ImageManager;

use App\Http\Requests\AddPhotosRequest;
use App\Http\Requests\AddPhotosToProductRequest;
use App\Http\Requests\AddPhotosToCategoryRequest;

use App\Services\Product\ProductService;
use App\Services\Product\CollectionService;
use App\Services\Product\PhotoService;
use App\Services\Product\FileService;
use App\Services\DropboxService;

class PhotoController extends Controller
{
    private $productService;
    private $collectionService;
    private $photoService;
    private $fileService;

    public function __construct()
    {
        $this->middleware('adminAuth');
        new BaseController;
        $this->productService = new ProductService;
        $this->collectionService = new CollectionService;
        $this->photoService = new PhotoService;
        $this->fileService = new FileService;
    }

    

    public function photos()
    {
        //dd(time());
        //$this->_handleDropboxPhotos();
        $photos = [];
        $email = auth::user()->email;
        try{
            //$photos = $this->photoService->unattachedPhotos();
            $products = $this->productService->products();
            $collections = $this->collectionService->collections();
            $dropBoxPhotos = [];
            $dropBoxPhotos = collect($dropBoxPhotos);
        } catch (\Throwable $th) {
            //dd($th->getResponse()->getReasonPhrase());
            if($th->getResponse()->getStatusCode() == 401) {
                DropboxService::refreshToken();
                $this->photos();
            }
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            dd($th->getMessage());
        }
        return view('admin/photos', compact('products', 'collections', 'dropBoxPhotos', 'email'));
    }



    /*
        Returns Json
    */
    public function get_dropbox_photos(Request $request)
    {
        $post = $request->all();
        $page = (isset($post['page'])) ? $post['page'] : 1;
        if(isset($post['email']) && !empty($post['email'])) {
            if(isset($post['category']) && !empty($post['category'])) {
                if($post['email'] == auth::user()->email) {
                    return $this->_handleDropboxPhotos($post['category'], $page);
                }else{
                    return response()->json([
                        'statusCode' => 401,
                        'message' => 'Wrong Email'
                    ], 401);
                }
            }else{
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Category missing'
                ], 404);
            }
        }else{
            return response()->json([
                'statusCode' => 404,
                'message' => 'Email missing'
            ], 404);
        }
    }

    private function _handleDropboxPhotos($category, $page=1, $retries=0)
    {
        // dd(session('dropBoxPhotos'));
        try{
            $photos = [];
            $session = '';
            switch($category) {
                case 'product' : $session = 'dropBoxProductPhotos'; $photos = $this->photoService->getDropboxProductPhotos($page); break;
                case 'collection' : $session = 'dropBoxCollectionPhotos'; $photos = $this->photoService->getDropboxCollectionPhotos(); break;
                case 'slide' : $session = 'dropBoxSlidePhotos'; $photos = $this->photoService->getDropboxSlidePhotos(); break;
            }
            
            //dd($photos);
            //dd(session('dropBoxPhotos'));
            return response()->json([
                'statusCode' => 200,
                'photos' => $photos
            ], 200);
        }catch (\Throwable $th) {
            //dd($th->getCode());
            //if(is_callable($th->getResponse) && $th->getCode() == 401) {
            if($th->getCode() == 401) {
                DropboxService::refreshToken();
                //dd('here');
                $retries++;
                if($retries <= 5) $this->_handleDropboxPhotos($page, $retries);
            }
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            if(session($session) != null && isset(session($session)[$page-1])) {
                return response()->json([
                    'statusCode' => 200,
                    'photos' => session($session)[$page-1]
                ], 200);
            }
            return response()->json([
                'statusCode' => 401,
                'message' => 'An error occured '.$th->getMessage()
            ], 401);
        }
    }

    public function product_photos()
    {
        $photos = [];
        try{
            $products = $this->productService->products();
            $collections = $this->collectionService->collections();
        } catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
        }
        return view('admin/product_photos', compact('products', 'collections'));
    }

    public function refresh_collection_photos()
    {
        return $this->collection_photos(true);
    }

    public function collection_photos($force=false)
    {
        $photos = [];
        try{
            $collections = $this->collectionService->collections();
            $photos = $this->photoService->getDropboxCollectionPhotos($force);
            $collectionPhotoFiles = $this->collectionService->getCollectionsPhotosAsFile();
            $filesArr = [];
            if(count($collectionPhotoFiles) > 0) {
                $filesArr = array_keys($collectionPhotoFiles); //generate an array of the paths of the collection photo files
            }
            if(count($photos) > 0) {
                foreach($photos as $photo) {
                    if(in_array($photo->file, $filesArr)) {
                        $photo->name = $collectionPhotoFiles[$photo->file]->name;
                        $photo->collection_id = $collectionPhotoFiles[$photo->file]->id;
                    }else{
                        $photo->name = null;
                        $photo->collection_id = '';
                    }
                }
            }
        } catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
        }
        //dd($photos);
        return view('admin/collection_photos', compact('photos', 'collections'));
    }

    public function slide_photos()
    {
        $photos = [];
        try{
            $photos = $this->photoService->slidePhotos();
            $products = $this->productService->products();
            $collections = $this->collectionService->collections();
        } catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
        }
        return view('admin/slide_photos', compact('photos', 'products', 'collections'));
    }

    public function add_photos(AddPhotosRequest $request)
    {
        $post = $request->all();
        //dd($post);
        $deleted_photos = [];
        if(isset($post['deleted_photos']) && !empty($post['deleted_photos'])) {
            $deleted_photos = explode(',', $post['deleted_photos']); 
        }
        try{
            $user_id = 1; 
            //auth::user()->id;
            $this->photoService->savePhotos($post['photos'], $user_id, $deleted_photos);
            return back()->with('msg', "Photos Added successfully");
        } catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return back()->with('error', $th->getMessage());
        }
    }

    public function delete($id)
    {
        try{
            $photo = $this->photoService->photo($id);
            if($photo) {
                $this->photoService->delete($photo);
                return back();
            }else{
                return back()->with('error', 'Photo was not found');
            }
        }catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return back()->with('error', 'An error occured, please contact the Administrator');
        }
    }

    public function add_to_category(AddPhotosToCategoryRequest $request)
    {
        try{
            $post = $request->all();
            $categoryObj = $this->validate_category_id($post['id'], $post['category']);
            if(($post['category'] != 'slide') && $categoryObj) {
                $fileIds = $this->addPhotosToFile($post['photos'], auth::user()->id, $post['category']);
                if($post['category'] != 'collection' || ($post['category'] == 'collection' && empty($post['photos']['collection_id']))) {
                    dd('dont!');
                    ($post['category']=='collection') ? $this->photoService->addPhotoToCategory($fileIds, $post['id'], $post['category']) : $this->photoService->addPhotosToCategory($fileIds, $post['id'], $post['category']);
                }
                return response()->json([
                    'statusCode' => 200,
                    'name' => $categoryObj->name,
                    'message' => 'Photo added successfully'
                ], 200);
            }else{
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Product/Collection does not exist'
                ], 404);
            }
        }catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return response()->json([
                'statusCode' => 500,
                'message' => 'An error occured, please contact the Administrator'
            ], 500);
        }
    }

    public function remove($id)
    {
        try{
            $photo = $this->photoService->photo($id);
            if($photo) {
                $photo->delete();
                //$this->refresh_photos('product');
                return response()->json([
                    'statusCode' => 200,
                    'message' => 'Photo deleted successfully'
                ], 200);
            }else{
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Photo not found'
                ], 404);
            }
        }catch(\Exception $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return response()->json([
                'statusCode' => 500,
                'message' => 'An error occured, please contact the Administrator'
            ], 500);
        }
    }

    public function refresh_photos($category)
    {
        try{
            switch($category) {
                case 'product' : $this->photoService->getDropboxProductPhotos(1, true); break;
                case 'collection' : $this->photoService->getDropboxCollectionPhotos(true); break;
                case 'slide' : $this->photoService->getDropboxSlidePhotos(true); break;
            }
            return response()->json([
                'statusCode' => 200,
                'message' => 'Photos refreshed successfully'
            ], 200);
        }catch(\Exception $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return response()->json([
                'statusCode' => 500,
                'message' => 'An error occured, please contact the Administrator'
            ], 500);
        }
    } 

    //Validating that the id i.e product_id/collection_id is valid
    private function validate_category_id($id, $category)
    {
        switch($category) {
            case "product" : return $this->productService->product($id); break;
            case "collection" : return $this->collectionService->collection($id); break;
            default : return false;
        }
    }

    /*
        Category can either be 'product', 'collection', 'slide'
    */
    private function addPhotosToFile($photos, $user_id, $category) 
    {
        //dd($photos);
        return ($category=='collection') ? $this->fileService->addDropBoxPhoto($photos, $user_id, $category) : $this->fileService->addDropBoxPhotos($photos, $user_id, $category);
    }

    
}
