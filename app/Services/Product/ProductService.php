<?php

namespace App\Services\Product;

use DB;
use Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Payment;
use App\Models\Order;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Product_collection;
use App\Models\Product_size;
use App\Models\Order_status;
use App\Models\File;

use App\Services\Product\CollectionService;
use App\Services\Product\SizeService;
use App\Services\Product\PhotoService;

class ProductService
{

    private $collectionService;
    private $sizeService;
    private $photoService;

    public function __construct()
    {
        $this->collectionService = new CollectionService;
        $this->sizeService = new SizeService;
        $this->photoService = new PhotoService;
    }

    public function allProducts()
    {
        return Product::all();
    }

    public function products()
    {
        return Product::where('deleted', '0')->orderBy('created_at', 'desc')->get();
    }

    public function product($id)
    {
        return Product::where('id', $id)->where('deleted', '0')->first();
    }

    public function productCollections($product)
    {
        $productCollections = [];
        if($product->collections->count() > 0) {
            foreach($product->collections as $collection) {
                $productCollections[] = $collection->id;
            }
        }
        return $productCollections;
    }

    public function productSizes($product)
    {
        $productSizes = [];
        if($product->product_sizes->count() > 0) {
            foreach($product->product_sizes as $productSize) {
                $productSizes[] = $productSize->size_id;
            }
        }
        return $productSizes;
    }

    public function productForm($id)
    {
        $productCollections = [];
        $collectionsData = [];
        $sizesData = [];
        $productSizes = [];
        $product = '';
        $title = 'Add a new Product';
        if ($id != null) {
            $title = 'Edit Product';
            $product = $this->product($id);
            if($product) {
                if($product->collections->count() > 0) {
                    foreach($product->collections as $collection) {
                        $productCollections[] = $collection->id;
                    }
                }
                if($product->product_sizes->count() > 0) {
                    foreach($product->product_sizes as $productSize) {
                        $productSizes[] = $productSize->size_id;
                    }
                }
            }
        }
        $sizes = $this->sizeService->sizes();
        foreach($sizes as $size) {
            $sizesData[$size->id] = $size->size;
        }
        $collections = $this->collectionService->collections();
        foreach($collections as $collection) {
            $collectionsData[$collection->id] = $collection->name;
        }
        return  [
                    'productCollections' => $productCollections,
                    'collectionsData' => $collectionsData,
                    'sizesData' => $sizesData,
                    'productSizes' => $productSizes,
                    'product' => $product,
                    'title' => $title
                ];
    }

    public function saveUpdate()
    {
        
            if($id==null) {
                $product->save();
                
            }else{
                $product->update();
            }
    }

    public function save($post)
    {
        $user_id = $post['user_id'];
        $product = new Product;
        $product->name = $post['name'];
        $product->price = $post['price'];
        $product->quantity = $post['quantity'];
        $product->description = $post['description'];
        $product->user_id = $user_id;
        $product->save();
        $category['id'] = $product->id;
        $category['name'] = 'product';
        $deleted_photos = [];
        if(isset($post['photos']) && !empty($post['photos'])) {
            $photos = $post['photos'];
            if(!empty($post['deleted_photos'])) {
                $deleted_photos = explode(',', $post['deleted_photos']); 
            }
            $this->photoService->savePhotos($photos, $user_id, $deleted_photos, $category);
        }
        return $product;
    }

    public function update($post, $product)
    {
        if(isset($post['name'])) $product->name = $post['name'];
        if(isset($post['price'])) $product->price = $post['price'];
        if(isset($post['quantity'])) $product->quantity = $post['quantity'];
        if(isset($post['description'])) $product->description = $post['description'];
        $product->update();
        return $product;
    }

    public function save_product_collections($collectionIds, $product)
    {
        $existingCollections = [];
        if($product->product_collections->count() > 0) {
            foreach($product->product_collections as $productCollection) {
                if(!in_array($productCollection->collection->id, $collectionIds)) {
                    $productCollection->delete();
                }else{
                    $existingCollections[] = $productCollection->collection->id;
                }
            }
        }
        foreach($collectionIds as $collection_id) {
            if(!in_array($collection_id, $existingCollections)) {
                $product_collection = new Product_collection;
                $product_collection->product_id = $product->id;
                $product_collection->collection_id = $collection_id;
                $product_collection->save();
            }
        }
    }

    public function save_product_sizes($sizeIds, $product)
    {
        $existingSizes = [];
        if($product->product_sizes->count() > 0) {
            foreach($product->product_sizes as $productSize) {
                if(!in_array($productSize->size->id, $sizeIds)) {
                    $productSize->delete();
                }else{
                    $existingSizes[] = $productSize->size->id;
                }
            }
        }
        foreach($sizeIds as $size_id) {
            if(!in_array($size_id, $existingSizes)) {
                $product_size = new Product_size;
                $product_size->product_id = $product->id;
                $product_size->size_id = $size_id;
                $product_size->save();
            }
        }
    }

    //public function updatePhoto($file, $photo)
}

?>