<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use session;
use stdClass;
use App\Models\Currency;
use App\Models\Currency_rate;
use App\Helpers\Helper;

use App\Services\DropboxService;
use App\Services\Product\PhotoService;

class BaseController extends Controller
{
    public function __construct()
    {
        if(time() > env('DROPBOX_TOKEN_EXPIRY') || ((env('DROPBOX_TOKEN_EXPIRY') - time()) <= 60)) {
            //dd(time().' < '.env('DROPBOX_TOKEN_EXPIRY'));
            //If the dropbox token has expired or will expire in less than 1minute
            try{ 
                DropboxService::refreshToken();
            }catch(\Throwable $th) {
                \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            }
        }

        if(time() > env('FETCH_DROPBOX_PHOTOS_EXPIRY')) {
            $photoservice = new PhotoService;
            try{
                $photoservice->getDropboxPhotos();
            }catch(\Exception $th) {
                \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            }
        }


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
