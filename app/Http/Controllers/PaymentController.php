<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Order\OrderService;
use App\Services\Order\PaymentService;
use App\Services\Utility\CompanyService;

class PaymentController extends Controller
{
    private $orderService;
    private $paymentService;
    private $companyService;

    public function __construct()
    {
        $this->middleware('customerAuth');
        $this->orderService = new OrderService;
        $this->paymentService = new PaymentService;
        $this->companyService = new CompanyService;
    }

    public function payment()
    { 
        $bankAccounts = $this->companyService->activeBankAccounts();
        $companyInfo = $this->companyService->companyInfo();
        return view('payment', compact('bankAccounts', 'companyInfo'));
    }
}
