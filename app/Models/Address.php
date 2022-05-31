<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (Address $address) {
            if($address->orders->count() > 0) {
                foreach ($address->orders as $order)
                {
                    $order->address_id = 0;
                    $order->update();
                }
            }
        });
    }
}
