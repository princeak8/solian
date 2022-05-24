<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Product\ProductService;
use App\Services\Product\CollectionService;
use App\Services\Product\PhotoService;
use App\Services\Product\FileService;

class CollectionController extends Controller
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
        $collection = $this->collectionService->collectionByName($name);
        //dd($collection->products);
        if($collection) {
            return view('collection', compact('collection'));
        }
        return redirect('/');
    }
}
