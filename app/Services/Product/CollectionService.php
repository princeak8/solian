<?php

namespace App\Services\Product;

use DB;
use Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Payment;
use App\Models\Order;
use App\Models\Product;
use App\Models\Product_collection;
use App\Models\Collection;
use App\Models\Order_status;
use App\Models\File;

class CollectionService
{

    public function allCollections()
    {
        return Collection::all();
    }

    public function newArrivals()
    {
        return Collection::where('name', 'new arrivals')->first();
    }

    public function collections($include_new_arrivals=true)
    {
        $newArrivals = $this->newArrivals();
        return Collection::where('deleted', '0')->when(!$include_new_arrivals, function($query) use($newArrivals) {
            $query->where('id', '!=', $newArrivals->id);
        })->orderBy('created_at', 'desc')->get();
    }

    public function collection($id=null)
    {
        return ($id==null) ? new Collection : Collection::where('id', $id)->where('deleted', '0')->first();
    }

    public function collectionByName($name=null)
    {
        return ($name==null) ? new Collection : Collection::where('name', $name)->where('deleted', '0')->first();
    }

    public function  collectionData($collections)
    {
        $collectionsData = [];
        foreach($collections as $collection) {
            $collectionsData[$collection->id] = $collection->name;
        }
        return $collectionsData;
    }

    public function save($post)
    {
        $id = $post['id'];
        if($id==null) {
            //Add action
            $collection = new Collection;
            $collection->name = $post['name'];
        }else{
            //edit action
            $collection = Collection::findOrFail($id);
            if(isset($post['name'])) $collection->name = $post['name'];
        }
        $collection->description = $post['description'];
        if($id==null) {
                //$photo = new Photo;
            // $uploadedPhoto = Utility::UploadFile($post['photo'], 'collections', Auth::user()->id);
            // if($uploadedPhoto && $uploadedPhoto != null) {
            //     $collection->photo = $uploadedPhoto->url;
            // }
            //$collection->save();
        }else{
            //$collection->update();
        }
        $existingProducts = [];
        if($collection->product_collections->count() > 0 && $id != null) {
            foreach($collection->product_collections as $productCollection) {
                if(!in_array($productCollection->product_id, $post['products'])) {
                    $productCollection->delete();
                }else{
                    $existingProducts[] = $productCollection->product_id;
                }
            }
        }
        // dd($existingProducts);
        // dd($post['products']);
        if(isset($post['products']) && !empty($post['products'])) {
            foreach($post['products'] as $product_id) {
                if(!in_array($product_id, $existingProducts)) {
                    $product_collection = new Product_collection;
                    $product_collection->product_id = $product_id;
                    $product_collection->collection_id = $collection->id;
                    $product_collection->save();
                }
            }
        }
    }

    /*
        Gets collections that has a photo and makes an array where the file path property of the photo is the key and the value is the collection
        Returns that array
    */
    public function getCollectionsPhotosAsFile()
    {
        $arr = [];
        $collections = $this->collections();
        if($collections->count() > 0) {
            foreach($collections as $collection) {
                if($collection->photo && $collection->photo->file) {
                    $arr[$collection->photo->file->path] = $collection;
                }
            }
        }
        return $arr;
    }
    //public function updatePhoto($file, $photo)
}

?>