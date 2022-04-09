<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Log;

use App\Services\Product\ProductService;
use App\Services\Product\PhotoService;
use App\Services\Order\OrderService;
use App\Services\Payment\PaymentService;
use App\Services\User\UserService;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\ChangeProductMainPhotoRequest;
use App\Http\Requests\AddPhotosRequest;

class ProductController extends Controller
{
    private $productService;
    private $photoService;
    private $orderService;
    private $paymentService;
    private $userService;

    public function __construct()
    {
        $this->middleware('adminAuth');
        $this->orderService = new OrderService;
        $this->paymentService = new PaymentService;
        $this->productService = new ProductService;
        $this->photoService = new PhotoService;
        $this->userService = new UserService;
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
            //dd($productData['product']);
            if($id != null && !$productData['product']) return redirect('admin/products')->with('error', 'The product was not found');

            $title = $productData['title'];
            $product = $productData['product'];
            $collectionsData = $productData['collectionsData'];
            $productCollections = $productData['productCollections'];
            $sizesData = $productData['sizesData'];
            $productSizes = $productData['productSizes'];
            // dd($productSizes);
            // dd($sizesData);
            return view('admin/product_form', compact('title', 'product', 'collectionsData', 'productCollections', 'sizesData', 'productSizes'));
        } catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return redirect('admin/products')->with('error', $th->getMessage());
        }
    }

    public function save(ProductRequest $request)
    {
        //dd(auth::user());
        $post = $request->all();
        $post['user_id'] = auth::user()->id;
        try{
            $product = $this->productService->save($post);
            if($product) {
                if(isset($post['collections'])) $this->productService->save_product_collections($post['collections'], $product);
                if(isset($post['sizes'])) $this->productService->save_product_sizes($post['sizes'], $product);
            }
            return back()->with("msg", "Product saved successfully");
        } catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return back()->with('error', $th->getMessage());
        }
    }

    public function update(UpdateProductRequest $request)
    {
        $post = $request->all();
        //dd($post['sizes']);
        $id = $request->get('id');
        try{
            $product = $this->productService->product($id);
            if($product) {
                $this->productService->update($post, $product);
                if(isset($post['collections'])) $this->productService->save_product_collections($post['collections'], $product);
                if(isset($post['sizes'])) $this->productService->save_product_sizes($post['sizes'], $product);
            }
            return back()->with("msg", "Product edited successfully");
        } catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return back()->with('error', $th->getMessage());
        }
    }

    public function change_main(ChangeProductMainPhotoRequest $request)
    {
        $post = $request->all();
        try{
            $product = $this->productService->product($post['product_id']);
            if($product) {
                if($product->user_id == auth::user()->id || $this->userService->isSuperAdmin(auth::user())) {
                $photo = $this->photoService->photo($post['photo_id']);
                    if($photo) {
                        if($photo->product_id == $product->id) {
                            $this->photoService->changeProductMainPhoto($product, $photo);
                            $response = [
                                'statusCode' => 200
                            ];
                            return response()->json($response, 200);
                        }else{
                            return response()->json(['statusCode'=>401, 'message'=>'Photo does not belong to the product'], 200);
                        }
                    }else{
                        return response()->json(['statusCode'=>404, 'message'=>'Photo not found'], 200);
                    }
                }else{
                    return response()->json(['statusCode'=>422, 'message'=>'You are not the user that created this product, hence not authorized'], 200);
                }
            }else{
                return response()->json(['statusCode'=>404, 'message'=>'Product not found'], 200);
            }
        }catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return response()->json(['statusCode'=>500, 'message'=>'An error occured'], 500);
        }
    }

    public function add_photo(AddPhotosRequest $request)
    {
        $post = $request->all();
        $product_id = $request->get('id');
        $deleted_photos = [];
        if(isset($post['deleted_photos']) && !empty($post['deleted_photos'])) {
            $deleted_photos = explode(',', $post['deleted_photos']); 
        }
        try{
            $category['id'] = $product_id;
            $category['name'] = 'product';
            $this->photoService->savePhotos($post['photos'], auth::user()->id, $deleted_photos, $category);
            return back();
        } catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return back()->with('error', $th->getMessage());
        }
    }
}
