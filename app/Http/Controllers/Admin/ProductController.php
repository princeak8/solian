<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Product\ProductService;
use App\Services\Product\PhotoService;
use App\Services\Order\OrderService;
use App\Services\Payment\PaymentService;


class ProductController extends Controller
{
    private $productService;
    private $photoService;
    private $orderService;
    private $paymentService;

    public function __construct()
    {
        //$this->middleware('adminAuth');
        $this->orderService = new OrderService;
        $this->paymentService = new PaymentService;
        $this->productService = new ProductService;
        $this->photoService = new PhotoService;
    }

    public function index()
    {
        $products = $this->productService->products();
        return view('admin/products', compact('products'));
    }

    public function show($id)
    {
        $product = $this->productService->product($id);
        if($product) {
            $product = new ProductResource($product);
            return view('admin/product', compact('product'));
        }
        return redirect('admin/products');
    }

    public function update_product_photos()
    {
        $this->productService->update();
    }

    public function update_slides()
    {
        $this->photoService->update();
    }

    public function update_collections()
    {
        $this->photoService->update_collections();
    }
}
