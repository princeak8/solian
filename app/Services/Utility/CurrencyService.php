<?php

namespace App\Services\Utility;

use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Helpers\Helper;
use Cloudinary;

use App\Models\Currency;
use App\Models\Currency_rate;


class CurrencyService
{

    public static function currencies()
    {
        return Currency::all();
    }

    public static function baseCurrency()
    {
        return Currency::where('active', 1)->first();
    }

    public static function rate($currency=null)
    {
        $baseCurrency = ($currency==null) ? self::baseCurrency() : $currency;
        return Currency_rate::where('currency_id', $baseCurrency->id)->first();
    }
}

?>