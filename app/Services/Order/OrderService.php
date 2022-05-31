<?php

namespace App\Services\Order;

use DB;
use Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Payment_status;
use App\Models\Order_status;
use App\Models\Order_product;
use App\Models\Payment;

use App\Services\Utility\CurrencyService;
use App\Services\User\UserService;
use App\Services\Utility\AddressService;

/**
 * Implementation of order service interface
 * @see OrderServiceInterface
 */
class OrderService 
{
    private $currencyService;

    public function __construct()
    {
        $this->currencyService = new CurrencyService;
    }

    public function pending_orders_count()
    {
        $pendingStatus = Order_status::where('status','pending')->first();
        return Order::where('order_status_id', $pendingStatus->id)->count();
    }

    public function pending_orders()
    {
        $pendingStatus = Order_status::where('status','pending')->first();
        return Order::where('order_status_id', $pendingStatus->id)->get();
    }

    public function getOrderByInvoiceNo($invoice_no)
    {
        return Order::where('invoice_no', $invoice_no)->first();
    }

    public function save($data, $user_id)
    {
        $total = 0;
        $baseCurrency = $this->currencyService->baseCurrency();
        $rate = $this->currencyService->rate();
        $orderProductArr = [];
        foreach($data['cart'] as $productQty) {
            $product = Product::find($productQty['0']);
            if($product) {
                $orderProduct = new Order_Product;
                $orderProduct->product_id = $product->id;
                $orderProduct->quantity = $productQty['1'];
                $orderProduct->price = $product->price / $rate->rate;
                $total += $orderProduct->price;
                $orderProductArr[] = $orderProduct;
            }
        }
        $orderObj = new Order;
        $orderObj->user_id = $user_id;
        $orderObj->total = $total;
        $orderObj->currency_id = $baseCurrency->id;
        $orderObj->order_status_id = Order_status::status('pending')->id;
        $orderObj->payment_status_id = Payment_status::unpaid()->id;
        $orderObj->address_id = $data['address_id'];
        if(isset($data['notes'])) $orderObj->notes = $data['notes'];
        $orderObj->save();


        foreach($orderProductArr as $orderProduct) {
            $orderProduct->order_id = $orderObj->id;
            $orderProduct->save();
        }
        $invoiceNo = $this->generateInvoiceNo($orderObj->id);
        $orderObj->invoice_no = $invoiceNo;
        $orderObj->update();

        return $orderObj;
    }

    private function generateInvoiceNo($id)
    {
        $yr = date('Y');
        $mn = date('n');
        $dy = date('j');
        return $dy.$mn.$yr.$id;
    }
}

?>