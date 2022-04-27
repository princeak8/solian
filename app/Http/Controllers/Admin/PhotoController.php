<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use stdClass;

use Intervention\Image\ImageManager;

use App\Http\Requests\AddPhotosRequest;
use App\Http\Requests\AddPhotosToProductRequest;

use App\Services\Product\ProductService;
use App\Services\Product\PhotoService;
use App\Services\DropboxService;

class PhotoController extends Controller
{
    private $productService;
    private $photoService;

    public function __construct()
    {
        $this->middleware('adminAuth');
        $this->productService = new ProductService;
        $this->photoService = new PhotoService;
    }

    

    public function photos()
    {
        //dd(env('as'));
        //$this->_handleDropboxPhotos();
        $photos = [];
        $email = auth::user()->email;
        try{
            $photos = $this->photoService->unattachedPhotos();
            $dropBoxPhotos = [];
            $dropBoxPhotos = collect($dropBoxPhotos);
            // $files = Storage::disk('dropbox')->files('web');
            // // dd($files);
            // $dropBoxPhotos = collect($files)->map(function($file) {
            //     $f = new stdClass();
            //     $f->file = $file;
            //     $f->url = Storage::disk('dropbox')->url($file);
            //     return $f;
            // });
                //$img = new ImageManager(); 
                // $img = ImageManager::make(Storage::disk('dropbox')->url($file)); //instance of the Image manager Class
                // $thumb = $img->resize(300, 200);
                
                // $f->url = Storage::disk('dropbox')->url($file);
                
                // $f->filename = File::basename($f->url);
                //$photosDetails[] = $f;
                //return Storage::disk('dropbox')->size($file);
            // foreach($files as $file) {
            //     $f = new stdClass();
            //     $f->file = $file;
            //     $f->url = Storage::disk('dropbox')->url($file);
            //     $dropBoxPhotos[] = $f;
            // }
            // dd($dropBoxPhotos);
        } catch (\Throwable $th) {
            //dd($th->getResponse()->getReasonPhrase());
            if($th->getResponse()->getStatusCode() == 401) {
                DropboxService::refreshToken();
                $this->photos();
            }
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            dd($th->getMessage());
        }
        return view('admin/photos', compact('photos', 'dropBoxPhotos', 'email'));
    }
    /*
        Returns Json
    */
    public function get_dropbox_photos(Request $request)
    {
        $post = $request->all();
        $page = (isset($post['page'])) ? $post['page'] : 1;
        if(isset($post['email']) && !empty($post['email'])) {
            if($post['email'] == auth::user()->email) {
                return $this->_handleDropboxPhotos($page);
            }else{
                return response()->json([
                    'statusCode' => 401,
                    'message' => 'Wrong Email'
                ], 401);
            }
        }else{
            return response()->json([
                'statusCode' => 404,
                'message' => 'Email missing'
            ], 404);
        }
    }

    private function _handleDropboxPhotos($page=1, $retries=0)
    {
        try{
            $photos = $this->photoService->getDropboxPhotos($page);
            return response()->json([
                'statusCode' => 200,
                'photos' => $photos
            ], 200);
        }catch (\Throwable $th) {
            // if($th->getResponse()->getStatusCode() == 401) {
            //     DropboxService::refreshToken();
            //     $retries++;
            //     if($retries <= 5) $this->_handleDropboxPhotos($page, $retries);
            // }
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
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
            $photos = $this->photoService->productPhotos();
        } catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
        }
        return view('admin/product_photos', compact('photos'));
    }

    public function collection_photos()
    {
        $photos = [];
        try{
            $photos = $this->photoService->collectionPhotos();
        } catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
        }
        return view('admin/collection_photos', compact('photos'));
    }

    public function slide_photos()
    {
        $photos = [];
        try{
            $photos = $this->photoService->slidePhotos();
        } catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
        }
        return view('admin/slide_photos', compact('photos'));
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

    public function add_to_product(AddPhotosToProductRequest $request)
    {
        try{
            $post = $request->all();
            if($this->productService->product($post['product_id'])) {
                $this->photoService->addPhotosToProduct($post['photos'], $post['product_id'], auth::user()->id);
                return response()->json([
                    'statusCode' => 200,
                    'message' => 'Photo added to product successfully'
                ], 200);
            }else{
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Product does not exist'
                ], 404);
            }
        }catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return back()->with('error', 'An error occured, please contact the Administrator');
        }
    }
}
