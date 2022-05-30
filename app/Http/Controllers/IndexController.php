<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

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
        //$this->middleware('adminAuth');
        //new BaseController;
        $this->productService = new ProductService;
        $this->collectionService = new CollectionService;
        $this->photoService = new PhotoService;
        $this->fileService = new FileService;
    }

    public function getMyAddresses()
    {
        // $params = $this->get_header_params('/v1/addresses/me/broker', 'get');
        // //dd($params);

        // $url = $this->baseUrl."/v1/addresses/me/broker";

        // $curl = curl_init($url);
        // curl_setopt($curl, CURLOPT_URL, $url);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        //     'X-API-TIMESTAMP: '.$params['time'],
        //     'X-API-SIGNATURE: ' . $params['signature'],
        //     'X-API-KEY: ' . $this->apiSecretKey)
        // );

        //for debug only!
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = Http::get('https://api.dropboxapi.com/oauth2/token'); //curl_exec($curl);
        //curl_close($curl);
        dd($resp);
    }
    
    public function index()
    {
        //dd(session('all_currencies'));
        $company = Company::first();
        if(!$company) {
            $company = new Company;
        }
        $products = $this->productService->products();
        $collections = $this->collectionService->collections(false);
        $newArrivals = $this->collectionService->newArrivals();
        $slides = $this->photoService->slidePhotos();
        if($slides->count() > 0) {
            $active = 0;
            foreach($slides as $slide) {
                if($active == 0) $slide->active = 1;
                $active = 1;
            }
        }
        //dd($slides);
        /*foreach($products as $product) {
            foreach($product->product_sizes as $productSize) {
                dd($productSize->size->size);
            }
        }*/
        return view('index', compact('company', 'products', 'collections', 'slides', 'newArrivals'));
    }
}
