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

    public function currencies()
    {
        return Currency::all();
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

    public function rates()
    {
        return Currency_rate::all();
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
}

?>