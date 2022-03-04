<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_size extends Model
{
    use HasFactory;

    /**
     * Sets the table.
     *
     * @var string
     */
    protected $table = 'products_sizes';

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function size()
    {
        return $this->belongsTo('App\Models\Size', 'size_id');
    }
}
