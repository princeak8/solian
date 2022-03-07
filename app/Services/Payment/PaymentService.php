<?php

namespace App\Services\Payment;

use DB;
use Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Payment;
use App\Models\Order;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Order_status;
/**
 * Implementation of payment service interface
 * @see PaymentServiceInterface
 */
class PaymentService
{

    public function unconfirmed_payments_count()
    {
        return Payment::where('confirmed', 0)->count();
    }

    public function unconfirmed_payments()
    {
        return Payment::where('confirmed', 0)->get();
    }
}

?>