<?php

namespace App\Services\Product;

use DB;
use Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Payment;
use App\Models\Order;
use App\Models\Product;
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

    public function collection($id)
    {
        return Collection::where('id', $id)->where('deleted', '0')->first();
    }

    public function  collectionData($collections)
    {
        $collectionsData = [];
        foreach($collections as $collection) {
            $collectionsData[$collection->id] = $collection->name;
        }
        return $collectionsData;
    }

    //public function updatePhoto($file, $photo)
}

?>