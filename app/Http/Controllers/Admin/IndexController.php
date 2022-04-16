<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use App\Services\Order\OrderService;
use App\Services\Payment\PaymentService;

use App\Models\Product;
use App\Models\Collection;
use App\Models\Order;
use App\Models\Order_status;
use App\Models\Payment;

class IndexController extends Controller
{
    private $orderService;
    private $paymentService;

    public function __construct()
    {
        $this->middleware('adminAuth');
        $this->orderService = new OrderService;
        $this->paymentService = new PaymentService;
    }

    private function pending()
    {
        $pendingStatus = Order_status::where('status','pending')->first();
        return Order::where('order_status_id', $pendingStatus->id)->get();
    }
    
    public function index()
    {
        $products = Product::where('deleted', '0')->orderBy('created_at', 'desc')->limit(5)->get();
        $collections = Collection::where('deleted', '0')->orderBy('created_at', 'desc')->limit(5)->get();
        $orders = Order::orderBy('created_at', 'desc')->limit(5)->get();
        $payments = Payment::orderBy('created_at', 'desc')->limit(5)->get();
        return view('admin/index', compact('products', 'collections', 'orders', 'payments'));
    }

    public function dropbox()
    {
        dd(Storage::disk('dropbox')->files('Phot'));
        $allFiles = collect(Storage::disk('dropbox')->files('Photos'))->map(function($file) {
            return Storage::disk('dropbox')->url($file);
        });
        dd($allFiles);
    }
}
