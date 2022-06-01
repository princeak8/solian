<?php

namespace App\Helpers;

use session;
use stdClass;
use App\Models\Currency;
use App\Models\Currency_rate;

    class Helper
    {
        /*
            Converts price to the current selected currency
        */
        public static function price_conversion($price)
        {
            if(session('currency')) { //if current currency is set in the session
                $currency = session('currency');
            }else{ //cuurent currency is not set in the session
                //get the default currency in the env file
                if(env('currency')){ //if default currency is set in the env file
                    $currency = env('currency');
                    session(['currency' => env('currency')]);
                }else{
                    $currencyObj = Currency::where('active', 1)->first();
                    if($currencyObj) {
                        $currency = $currencyObj->name;
                        session(['currency' => $currencyObj->name]);
                        session(['currency_sign' => $currencyObj->sign]);
                    }
                }
            }
            if(session('rates') && session('rates')->{$currency}) { //if currency rates is set in the session
                $rate = session('rates')->{$currency};
            }else{
                $currencyObj = Currency::where('name', $currency)->first();
                if($currencyObj) {
                    $currency_rate = Currency_rate::where('currency_id', $currencyObj->id)->first();
                }
                if($currency_rate) {
                    $rate = $currency_rate->rate;
                }   
                $currency_rates = Currency_rate::all();
                if(!session('rates')) { // if rates is not set in the session
                    $object = new stdClass();
                    session(['rates' => $object]); //set rates to empty object in the session
                }
                if($currency_rates->count() > 0) {
                    foreach($currency_rates as $currRate) {
                        session('rates')->$currency = $currRate->rate;
                    }
                }
            }

            if(isset($rate)) {
                $price = (float)$price * (float)$rate;
            }
            return $price;
        }

        public static function setEnvironmentValue($envKey, $envValue, $new=false)
        {
            $envFile = app()->environmentFilePath();
            $str = file_get_contents($envFile);

            $oldValue = env($envKey);
            //dd($oldValue);

            $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);
            //dd($str);
            $fp = fopen($envFile, 'w');
            fwrite($fp, $str);
            fclose($fp);
            // dd(env($envKey));
        }

        public static function setMultiEnvironmentValue($envVars)
        {
            $envFile = app()->environmentFilePath();
            $str = file_get_contents($envFile);
            foreach($envVars as $envKey=>$envValue) {
                $oldValue = env($envKey);
                if($oldValue != null) {
                    $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);
                }else{
                    $str .= "\n {$envKey}={$envValue}\n";
                }
            }
            //dd($str);
            $fp = fopen($envFile, 'w');
            fwrite($fp, $str);
            fclose($fp);
        }

    }

?>