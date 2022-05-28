<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Http\Requests\PlaceOrderRequest;

use App\Services\Utility\UtilityService;
use App\Services\Order\OrderService;
use App\Services\User\UserService;
use App\Services\Utility\AddressService;

class OrderController extends Controller
{
    private $utilityService;
    private $orderService;
    private $userService;
    private $addressService;

    public function __construct()
    {
        $this->middleware('customerAuth', ['only'=>['place_order']]);
        $this->utilityService = new UtilityService;
        $this->orderService = new OrderService;
        $this->userService = new UserService;
        $this->addressService = new AddressService;
    }

    public function checkout_page()
    {
        $countries = $this->utilityService->countries();
        return view('checkout', compact('countries'));
    }

    public function place_order(PlaceOrderRequest $request)
    {
        $post = $request->all();
        try{
            if(empty(auth::user()->address_id) || $post['addressDefault']==1) {
                $address = $this->addressService->save($post);
                $post['address_id'] = $address->id;
            }else{
                $post['address_id'] = auth::user()->address_id;
            }
            $this->orderService->save($post, auth::user()->id);

            //Send email to Solian and the customer

            return response()->json([
                'statusCode' => 200,
                'message' => 'order saved successfully'
            ], 200);
        }catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return response()->json([
                'statusCode' => 500,
                'message' => 'An error occured, please contact the Administrator'
            ], 500);
        }
    }
}
