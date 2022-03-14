<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Product\ProductService;
use App\Services\Product\PhotoService;

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

    public function add_photos(SavePhotoRequest $request)
    {
        $post = $request->all();
        $deleted_photos = [];
        if(isset($post['deleted_photos']) && !empty($post['deleted_photos'])) {
            $deleted_photos = explode(',', $post['deleted_photos']); 
        }
        try{
            $this->photoService->savePhotos($post['photos'], auth::user()->id, $deleted_photos);
            return back();
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
}
