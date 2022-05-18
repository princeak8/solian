<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function product_collections()
    {
        $productCollections = $this->hasMany('App\Models\Product_collection', 'collection_id', 'id');
        //dd($productCollections);
        foreach($productCollections as $key=>$productCollection) {
            //dd($productCollection->product);
            if($productCollection->product == null) {
                unset($productCollections[$key]);
            }
        }
        return $productCollections;
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'products_collections')->where('deleted', 0);
    }

    public function photo()
    {
        return $this->hasOne('App\Models\Photo');
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (Collection $collection) {

            foreach ($collection->product_collections as $product_collection)
            {
                $product_collection->collection_id = 0;
                $product_collection->update();
            }
        });
    }
}
