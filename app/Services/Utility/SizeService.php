<?php

namespace App\Services\Utility;

use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Helpers\Helper;

use App\Models\Size;
use App\Models\Size_range;
use App\Models\Size_type;


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

    public function sizeRanges()
    {
        return Size_range::all();
    }
    
    public function sizeRange($id)
    {
        return Size_range::find($id);
    }

    public function sizeTypes()
    {
        return Size_type::all();
    }
    
    public function sizeType($id)
    {
        return Size_type::find($id);
    }

    public function updateSizeRange($size_range, $data)
    {
        $size_range->min = $data['min'];
        $size_range->max = $data['max'];
        $size_range->update();
    }
}

?>