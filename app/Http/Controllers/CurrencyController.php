<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Utility\CurrencyService;

use App\Http\Resources\CurrencyRateResource;

class CurrencyController extends Controller
{
    private $currencyService;

    public function __construct()
    {
        $this->currencyService = new CurrencyService;
    }

    public function get_rate($id=null)
    {
        try{
            if($id != null) $currency = $this->currencyService->currency($id);
            if($id != null && !$currency) {
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Currency not found'
                ], 404);
            }
            $rate = ($id==null) ? $this->currencyService->rate() : $this->currencyService->rate($currency);
            return response()->json([
                'statusCode' => 200,
                'data' => new CurrencyRateResource($rate),
                'message' => 'successfull'
            ], 200);
        }catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return response()->json([
                'statusCode' => 500,
                'message' => 'An error occured, please contact the Administrator'
            ], 500);
        }
    }

    public function get_rates()
    {
        try{
            $rates = $this->currencyService->rates();
            return response()->json([
                'statusCode' => 200,
                'data' => CurrencyRateResource::collection($rates),
                'message' => 'successfull'
            ], 200);
        }catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return response()->json([
                'statusCode' => 500,
                'message' => 'An error occured, please contact the Administrator'
            ], 500);
        }
    }

    public function set_currency(Request $request)
    {
        $post = $request->all();
        if(isset($post['currency'])) {
            //session(['currency' => $post['currency']]);
            try{
                $currencyObj = $this->currencyService->getCurrencyByName($post['currency']); //get the default currency from db
                if($currencyObj) {
                    //session(['currency_sign' => $currencyObj->sign]); //set the default currency sign
                    $this->currencyService->switchCurrency($currencyObj);
                    $response = [
                        'currencySign' => $currencyObj->sign,
                        'conversionRate' => $currencyObj->rate->rate
                    ];
                    return response()->json($response, 200);
                }else{
                    return response()->json([
                        'statusCode' => 404,
                        'message' => 'Currency not found'
                    ], 404);
                }
            }catch (\Throwable $th) {
                \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
                return response()->json([
                    'statusCode' => 500,
                    'message' => 'An error occured, please contact the Administrator'
                ], 500);
            }
        }else{
            return response()->json([
                'statusCode' => 422,
                'message' => 'Currency field is required'
            ], 422);
        }
    }
}
