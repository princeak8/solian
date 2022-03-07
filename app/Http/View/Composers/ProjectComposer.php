<?php

namespace App\Http\View\Composers;

use App\Services\Order\OrderService;
use App\Services\Payment\PaymentService;

use Illuminate\View\View;

use App\Models\Product;
use App\Models\Collection;
use App\Models\Order;
use App\Models\Order_status;
use App\Models\Payment;

class ProjectComposer
{
    private $orderService;
    private $paymentService;

    protected $pendingOrdersCount;
    protected $unconfirmedPaymentsCount;
    protected $collectionCount;
    protected $productCount;

    /**
     * Create a new profile composer.
     *
     * @param  \App\Repositories\UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        $this->orderService = new OrderService;
        $this->paymentService = new PaymentService;

        $this->pendingOrderCount = $this->orderService->pending_orders_count();
        $this->unconfirmedPaymentCount = $this->paymentService->unconfirmed_payments_count();
        $this->productCount = Product::all()->count();
        $this->collectionCount = Collection::all()->count();
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('pendingOrderCount', $this->pendingOrderCount)->with('unconfirmedPaymentCount', $this->unconfirmedPaymentCount)
        ->with('productCount', $this->productCount)->with('collectionCount', $this->collectionCount);
    }
}

?>