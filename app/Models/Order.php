<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function orderStatus()
    {
        return $this->belongsTo('App\Models\Order_status', 'order_status_id');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Address', 'address_id');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment', 'payment_mode_id', 'id');
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (Order $order) {

            foreach ($order->payments as $payment)
            {
                $payment->order_id = 0;
                $payment->update();
            }
        });
    }
}
