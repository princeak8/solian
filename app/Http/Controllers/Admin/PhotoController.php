<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\AddPhotosRequest;

use App\Services\Product\ProductService;
use App\Services\Product\PhotoService;

class PhotoController extends Controller
{
    private $productService;
    private $photoService;

    public function __construct()
    {
        //$this->middleware('adminAuth');
        $this->productService = new ProductService;
        $this->photoService = new PhotoService;
    }

    public function photos()
    {
        $photos = [];
        try{
            $photos = $this->photoService->unattachedPhotos();
        } catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
        }
        return view('admin/photos', compact('photos'));
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
}
