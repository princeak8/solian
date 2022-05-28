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
}
