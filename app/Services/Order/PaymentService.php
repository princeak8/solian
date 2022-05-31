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
 * Implementation of payment service interface
 * @see PaymentServiceInterface
 */
class PaymentService 
{
    private $currencyService;

    public function __construct()
    {
        $this->currencyService = new CurrencyService;
    }

    public function paid_orders()
    {
        $paidStatus = Payment_status::paid();
        return Order::where('payment_status_id', $paidStatus->id)->get();
    }
    
    public function unpaid_orders()
    {
        $unpaidStatus = Payment_status::unpaid();
        return Order::where('payment_status_id', $unpaidStatus->id)->get();
    }

    public function save($data, $user_id)
    {
        //
    }
}

?>