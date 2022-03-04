<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_mode extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function payments()
    {
        return $this->hasMany('App\Models\Payment', 'payment_mode_id', 'id');
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (Payment $payment) {

            foreach ($payment->payments as $payment)
            {
                $payment->payment_mode_id = 0;
                $payment->update();
            }
        });
    }
}
