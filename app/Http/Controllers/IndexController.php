<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use session;

use Cloudinary;

//use Helper;
use App\Helpers\Helper;

use App\Services\Product\ProductService;
use App\Services\Product\CollectionService;
use App\Services\Product\PhotoService;
use App\Services\Product\FileService;

use App\Models\Company;

class IndexController extends BaseController
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
    
    public function index()
    {
        //dd(session('all_currencies'));
        $company = Company::first();
        if(!$company) {
            $company = new Company;
        }
        $products = $this->productService->products();
        $collections = $this->collectionService->collections();
        $newArrivals = $this->collectionService->newArrivals();
        //dd($newArrivals);
        $slides = $this->photoService->slidePhotos();
        /*foreach($products as $product) {
            foreach($product->product_sizes as $productSize) {
                dd($productSize->size->size);
            }
        }*/
        return view('index', compact('company', 'products', 'collections', 'slides', 'newArrivals'));
    }
}
