<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Currency;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected $dates = [
        'created_at',
        'updated_at',
        // your other new column
    ];

    public function getMainAttribute()
    {
        $mainPhoto = '';
        $firstPhoto = '';
        foreach($this->photos as $photo) {
            if(empty($firstPhoto)) {
                $firstPhoto = $photo->file->file_url;
            }
            if($photo->main == 1) {
                $mainPhoto = $photo->file->ufile_url;
            }
        }
        if(empty($mainPhoto)) {
            $mainPhoto = $firstPhoto;
        }
        if(empty($mainPhoto)) $mainPhoto = env('APP_URL')."public/images/no_pic.png";
        return $mainPhoto;
    }

    public function getMainIdAttribute()
    {
        $mainPhoto = '';
        $firstPhoto = '';
        foreach($this->photos as $photo) {
            if(empty($firstPhoto)) {
                $firstPhoto = $photo;
            }
            if($photo->main == 1) {
                $mainPhoto = $photo;
            }
        }
        if(empty($mainPhoto)) {
            $mainPhoto = $firstPhoto;
        }
        return (empty($mainPhoto)) ? '' : $mainPhoto->id;
    }

    public function getMainthumbAttribute()
    {
        $mainPhoto = '';
        $firstPhoto = '';
        foreach($this->photos as $photo) {
            if(empty($firstPhoto)) {
                $firstPhoto = $photo->file->thumb;
            }
            if($photo->main == 1) {
                $mainPhoto = $photo->file->thumb;
            }
        }
        if(empty($mainPhoto)) {
            $mainPhoto = $firstPhoto;
        }
        if(empty($mainPhoto)) $mainPhoto = env('APP_URL')."public/images/no_pic.png";
        return $mainPhoto;
    }

    public function getConvertedPriceAttribute()
    {
        $price = $this->price;
        $currency = Currency::active();
        $rate = $currency->rate->rate;
        // if(isset( $currency) && session('rates') && session('rates')->{$currency}) { //if currency rates is set in the session
        //     $rate = session('rates')->{$currency};
        // }

        if(isset($rate)) {
            $price = floatval($this->price) / floatval($rate);
        }
        return $price;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function photos()
    {
        $photos = $this->hasMany('App\Models\Photo', 'product_id', 'id')->where('deleted', '0');
        return $photos;
    }

    public function product_collections()
    {
       $productCollections = $this->hasMany('App\Models\Product_collection', 'product_id', 'id');
       foreach($productCollections as $key=>$productCollection) {
           if($productCollection->product == null) {
               unset($productCollections[$key]);
           }
       }
       return $productCollections;
    }

    public function collections()
    {
        return $this->belongsToMany('App\Models\Collection', 'products_collections')->where('deleted', 0);
    }

    public function product_sizes()
    {
        return $this->hasMany('App\Models\Product_size', 'product_id', 'id');
    }

    public function order_products()
    {
        return $this->hasMany('App\Models\Order_product', 'product_id', 'id');
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (Product $product) {

            foreach ($product->product_collections as $product_collection)
            {
                $product_collection->delete();
            }

            foreach ($product->order_products as $order_product)
            {
                $order_product->delete();
            }
        });
    }
}
