<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_collection extends Model
{
    use HasFactory;

    protected $table = 'products_collections';

    protected $fillable = [];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id')->where('deleted', '0');
    }

    public function collection()
    {
        return $this->belongsTo('App\Models\Collection', 'collection_id')->where('deleted', '0');
    }
}
