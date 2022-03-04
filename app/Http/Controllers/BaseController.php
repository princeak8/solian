<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use session;
use stdClass;
use App\Models\Currency;
use App\Models\Currency_rate;

class BaseController extends Controller
{
    public function __construct()
    {
        if(!session('currency')) {
            if(env('currency')){ //if default currency is set in the env file
                session(['currency' => env('currency')]);
            }else{
                session(['currency' => 'NGN']); // set default currency to NGN
            }
            $currencyObj = Currency::where('name', session('currency'))->first(); //get the default currency from db
            session(['currency_sign' => $currencyObj->sign]); //set the default currency sign
        }
        if(!session('currency_sign')) {
            $currencyObj = Currency::where('name', session('currency'))->first();
            session(['currency_sign' => $currencyObj->sign]);
        }

        if(!session('all_currencies')) {
            $currencies = Currency::all(); //get all the currencies in the db
            //session(['currencies' => array()]);
            foreach($currencies as $currency) { //loop through all the currencies in the db
                $obj = new stdClass();
                $obj->name = $currency->name;
                $obj->active = $currency->active;
                //dd($obj);
                session()->push('all_currencies', $obj);
                //session(['currencie' => $obj]);
                //session('currencies')[] = $obj;
                //dd(session('currencies'));
            }
            //session(['currencie' => $obj]);
        }
        //dd(session('currencies'));

        if(!session('rates')) {
            $object = new stdClass();
            session(['rates' => $object]);
            session('rates')->{session('currency')} = 1;
            $currencyObj = Currency::where('name', session('currency'))->first();
            $currency_rate = Currency_rate::where('currency_id', $currencyObj->id)->first();
            if(!$currency_rate) {
                $currency_rate = new Currency_rate;
            }
            $currency_rate->currency_id = $currencyObj->id;
            $currency_rate->rate = 1;
            $currency_rate->save();
        }
    }
}
