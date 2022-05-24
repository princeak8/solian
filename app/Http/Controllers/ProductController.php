<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Storage;

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
            // if($product->photos->count() > 0) {
            //    foreach($product->photos as $photo) {
            //         $adapter = \Storage::disk('dropbox')->getAdapter();
            //         $client = $adapter->getClient();
            //         $link = $client->createTemporaryDirectLink('/web/products/_MG_7635.jpg');
            //        dd($link);
            //         //$photo->file->secure_url = Storage::disk('dropbox')->url($photo->file->path);
            //    } 
            // }
            return view('product', compact('product', 'related'));
        }
        return redirect('/');
    }
}

// https://ucf4df2646cbdd29a9b8092f9289.dl.dropboxusercontent.com/cd/0/get/Bl6j4Cwj_xxUhFKQq0Yj0rmyeQMDb5C_SAyeBOta1smMvJ87Tha-wWFGAvgSM9tnmoQs2XY9gAFHZf4SdXbDGSA6brqDQKFL4zGdH_FC0
// vQXr5ULXIK4qKmRVctn4nFVXHUNSfTq8OOW3YzvyaygneDebbcDcmsqHBMmG0RwVnQ_9rVa4cSTBuaFRDxwRnn7kTo/file

// https://uc2daad43f67798fbcdb4f496320.dl.dropboxusercontent.com/cd/0/get/Bl0O5klzglHhEbXSUHsuh-fIAs_PDsQBUetN4lyNuxNRWXvNGPgAq8s7W1VqpDkNG-0Rf2X7z4FkVQU3K3um3b-8bHZPUR2ostSXy4Uss
// cxL0ZRKWgVBqiw7YaLtM4ILd54TVaWwznjsUwhJKnRPW2NVKsMSz_Hh3TIiKRYj8e_URYimiwhHS8p_SVUO7jFJN7Q/file