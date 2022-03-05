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
        //dd($collections);
        return view('index', compact('company', 'products', 'collections', 'slides'));
    }

    public function  upload(Request $request)
    {
        $file = $request->file('photo');
        $result = $request->file('photo')->storeOnCloudinary('solian/products');
        dd($result);
    }
}
