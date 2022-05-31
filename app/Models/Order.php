<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function getTotalAttribute()
    {
        $total = 0;
        if($this->orderProducts->count() > 0) {
           foreach($this->orderProducts as $orderProduct) {
                $total += $orderProduct->price;
           } 
        }
        return $total;
    }

    public function orderStatus()
    {
        return $this->belongsTo('App\Models\Order_status', 'order_status_id');
    }

    public function paymentStatus()
    {
        return $this->belongsTo('App\Models\Payment_status');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Address', 'address_id');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function orderProducts()
    {
        return $this->hasMany('App\Models\Order_product');
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
