<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    public static function active()
    {
        $active = Self::where('active', 1)->first();
        if(!$active) $active = Self::first();
        return $active;
    }

    public function rate()
    {
        return $this->hasOne('App\Models\Currency_rate');
    }

    public static function naira()
    {
        return Self::where('name', 'NGN')->first();
    }
    
    public static function dollar()
    {
        return Self::where('name', 'USD')->first();
    }

    public static function Euro()
    {
        return Self::where('name', 'EUR')->first();
    }

    public static function pounds()
    {
        return Self::where('name', 'GBP')->first();
    }
}
