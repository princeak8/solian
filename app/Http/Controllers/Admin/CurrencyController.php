<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Services\Utility\CurrencyService;

class CurrencyController extends Controller
{
    private $currencyService;

    public function __construct()
    {
        $this->middleware('adminAuth');
        $this->currencyService = new CurrencyService;
    }

    public function rates()
    {
        try{
            $rates = $this->currencyService->rates(false);
            return view('admin/rates', compact('rates'));
        }catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            dd($th->getMessage());
            return redirect('admin/');
        }
    }

    public function update_rate(Request $request)
    {
        $post = $request->all();
        $validator = Validator::make($post, [
            'rate' => 'required|numeric|between:1,9999.99',
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $rate = $this->currencyService->getRateById($post['id']);
            if($rate) {
                $this->currencyService->updateRate($post, $rate);
                return response()->json([
                    'statusCode' => 200,
                    'message' => 'successfull operation'
                ], 200);
            }else{
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Rate not found'
                ], 404);
            }
        }catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return response()->json([
                'statusCode' => 500,
                'message' => 'An error occured, please contact the Administrator'
            ], 500);
        }
    }
}
