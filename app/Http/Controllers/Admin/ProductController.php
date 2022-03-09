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
            return view('admin/product', compact('product'));
        }
        return redirect('admin/products');
    }

    public function product_form($id = null)
    {
        $productCollections = [];
        $collectionsData = [];
        $sizesData = [];
        $productSizes = [];
        try{
            $productData = $this->productService->productForm($id);
            if(!$productData['product'])  return redirect('admin/products')->with('error', 'The product was not found');

            $title = $productData['title'];
            $product = $productData['product'];
            $collectionsData = $productData['collectionsData'];
            $productCollections = $productData['productCollections'];
            $sizesData = $productData['sizesData'];
            $productSizes = $productData['productSizes'];
            //dd($collectionsData);
            //dd($productSizes);
            return view('admin/product_form', compact('title', 'product', 'collectionsData', 'productCollections', 'sizesData', 'productSizes'));
        } catch (\Throwable $th) {
            echo $th->getMessage();
            return redirect('admin/products')->with('error', $th->getMessage());
        }
    }

    public function save(ProductRequest $request)
    {
        $post = $request->all();
        //dd($post['sizes']);
        $id = $request->get('id');
        try{
            if($id==null) {
                //Add action
                $product = $this->productService->save($post);
            }else{
                //edit action
                $product = $this->productService->product($id);
                if($product) $this->productService->update($post, $product);
            }
            if($product) {
                $this->productService->save_product_collections($post['collections'], $product);
                $this->productService->save_product_sizes($post['sizes'], $product);
            }
            if($id==null) {
                return redirect('admin/products');
            }
            return back()->with("msg", "Product edited successfully");
        } catch (\Throwable $th) {
            echo $th->getMessage();
            return back()->with('error', $th->getMessage());
        }
    }
}
