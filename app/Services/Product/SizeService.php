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
use App\Models\Size;

class SizeService
{

    public function sizes()
    {
        return Size::all();
    }

    public function size($id)
    {
        return Size::find($id);
    }

    public function sizesData($sizes)
    {
        $sizesData = [];
        foreach($sizes as $size) {
            $sizesData[$size->id] = $size->size;
        }
        return $sizesData;
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

    public function update()
    {
        //
    }

    //public function updatePhoto($file, $photo)
}

?>