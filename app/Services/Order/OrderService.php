<?php

namespace App\Services\Order;

use DB;
use Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Order_status;
use App\Models\Payment;

/**
 * Implementation of order service interface
 * @see OrderServiceInterface
 */
class OrderService 
{

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
}

?>