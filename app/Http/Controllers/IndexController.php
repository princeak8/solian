<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use session;

use Cloudinary;

//use Helper;
use App\Helpers\Helper;

use App\Models\Product;
use App\Models\Collection;
use App\Models\Photo;
use App\Models\Company;
use App\Models\Currency;
use App\Models\Currency_rate;

class IndexController extends BaseController
{
    
    public function index()
    {
        //dd(session('all_currencies'));
        $company = Company::first();
        if(!$company) {
            $company = new Company;
        }
        $products = Product::where('deleted', '0')->orderBy('created_at', 'desc')->limit(10)->get();
        /*foreach($products as $product) {
            foreach($product->product_sizes as $productSize) {
                dd($productSize->size->size);
            }
        }*/
        $collections = Collection::where('deleted', '0')->orderBy('created_at', 'desc')->get();
        $slides = Photo::slides();
        //dd($slides);
        return view('index', compact('company', 'products', 'collections', 'slides'));
    }

    public function  upload(Request $request)
    {
        $file = $request->file('photo');
        $result = $request->file('photo')->storeOnCloudinary('solian/products');
        $url = $result->getPath(); // Get the url of the uploaded file; http
        $secureUrl = $result->getSecurePath(); // Get the url of the uploaded file; https
        $size = $result->getSize(); // Get the size of the uploaded file in bytes
        $rSize = $result->getReadableSize(); // Get the size of the uploaded file in bytes, megabytes, gigabytes or terabytes. E.g 1.8 MB
        $type = $result->getFileType(); // Get the type of the uploaded file
        $filename = $result->getFileName(); // Get the file name of the uploaded file
        $originalFilename = $result->getOriginalFileName(); // Get the file name of the file before it was uploaded to Cloudinary
        $publicId = $result->getPublicId(); // Get the public_id of the uploaded file
        $ext = $result->getExtension(); // Get the extension of the uploaded file
        $width = $result->getWidth(); // Get the width of the uploaded file
        $height = $result->getHeight(); // Get the height of the uploaded file
        $time = $result->getTimeUploaded(); // Get the time the file was uploaded
        $mime = $result->getMimeType();
        $uploadData = [
            "url" => $url,
            "secureUrl" => $secureUrl,
            "size" => $size,
            "rSize" => $rSize,
            "type" => $type,
            "filename" => $filename,
            "originalFilename" => $originalFilename,
            "publicId" => $publicId,
            "ext" => $ext,
            "width" => $width,
            "height" => $height,
            "time" => $time,
        ];
        dd($uploadData);
    }
}
