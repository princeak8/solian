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

    public function currencies($includeBase=true)
    {
        return ($includeBase) ? Currency::all() : Currency::where('name', '!=', 'NGN')->get();
    }

    public function baseCurrency()
    {
        return Currency::where('active', 1)->first();
    }

    public function currency($id)
    {
        return Currency::find($id);
    }

    public function getCurrencyByName($name)
    {
        return Currency::where('name', $name)->first();
    }

    public function rate($currency=null)
    {
        $baseCurrency = ($currency==null) ? self::baseCurrency() : $currency;
        return Currency_rate::where('currency_id', $baseCurrency->id)->first();
    }

    public function getRateById($id)
    {
        return Currency_rate::find($id);
    }

    public function rates($includeBase=true)
    {
        return ($includeBase) ? Currency_rate::all() : Currency_rate::whereHas('currency', function($query) use ($includeBase) {
            $query->where('name', '!=', 'NGN');
        })->get();
    }

    public function switchCurrency($currency)
    {
        $baseCurrency = $this->baseCurrency();
        if($baseCurrency->id != $currency->id) {
            $currency->active = 1;
            $currency->update();
            $baseCurrency->active = 0;
            $baseCurrency->update();
        }
    }

    public function updateRate($data, $rate)
    {
        $rate->rate = $data['rate'];
        $rate->update();
    }
}

?>