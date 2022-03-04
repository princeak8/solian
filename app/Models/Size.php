<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    public function product_sizes()
    {
        return $this->hasMany('App\Models\Product_size', 'product_id', 'id');
    }
    
    public function size_ranges()
    {
        return $this->hasMany('App\Models\Size_range', 'size_id', 'id');
    }
}
