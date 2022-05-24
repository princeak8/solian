<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Product\ProductService;
use App\Services\Product\CollectionService;
use App\Services\Product\PhotoService;
use App\Services\Product\FileService;

class ProductController extends Controller
{
    private $productService;
    private $collectionService;
    private $photoService;
    private $fileService;

    public function __construct()
    {
        $this->productService = new ProductService;
        $this->collectionService = new CollectionService;
        $this->photoService = new PhotoService;
        $this->fileService = new FileService;
    }

    public function show($name)
    {
        $product = $this->productService->productByName($name);
        $related = $this->productService->related($product);
        if($product) {
            return view('product', compact('product', 'related'));
        }
        return redirect('/');
    }
}
