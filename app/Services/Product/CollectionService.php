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

    public function collections()
    {
        return Collection::where('deleted', '0')->orderBy('created_at', 'desc')->get();
    }

    public function collection($id=null)
    {
        return ($id==null) ? new Collection : Collection::where('id', $id)->where('deleted', '0')->first();
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
        }else{
            //edit action
            $collection = Collection::findOrFail($id);
        }
        $collection->name = $post['name'];
        $collection->description = $post['description'];
        if($id==null) {
                //$photo = new Photo;
            // $uploadedPhoto = Utility::UploadFile($post['photo'], 'collections', Auth::user()->id);
            // if($uploadedPhoto && $uploadedPhoto != null) {
            //     $collection->photo = $uploadedPhoto->url;
            // }
            $collection->save();
        }else{
            $collection->update();
        }
        $existingProducts = [];
        if($collection->product_collections->count() > 0 && $id != null) {
            foreach($collection->product_collections as $productCollection) {
                if(!in_array($productCollection->product->id, $post['products'])) {
                    $productCollection->delete();
                }else{
                    $existingCollections[] = $productCollection->product->id;
                }
            }
        }
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

    //public function updatePhoto($file, $photo)
}

?>