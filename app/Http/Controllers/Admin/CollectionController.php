<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

use App\Services\Product\ProductService;
use App\Services\Product\PhotoService;
use App\Services\Product\CollectionService;

class CollectionController extends Controller
{
    private $productService;
    private $photoService;
    private $collectionService;

    public function __construct()
    {
        $this->middleware('adminAuth');
        new BaseController;
        $this->collectionService = new CollectionService;
        $this->productService = new ProductService;
        $this->photoService = new PhotoService;
    }

    public function index()
    {
        $collections = $this->collectionService->collections();
        return view('admin/collections', compact('collections'));
    }

    public function show($id)
    {
        $collection = $this->collectionService->collection($id);
        //dd($collection->products);
        if($collection) {
            return view('admin/collection', compact('collection'));
        }
        return redirect('admin/collections');
    }

    public function collection_form($id = null)
    {
        $productCollections = [];
        $productsData = [];

        try{
            if ($id == null) {
                $collection = new Collection;
                $title = 'Add a new Collection';
            }else{
                $title = 'Edit Collection';
                $collection = $this->collectionService->collection($id);
                if($collection->products->count() > 0) {
                    foreach($collection->products as $product) {
                        $productCollections[] = $product->id;
                    }
                }
            }
            $products = $this->productService->products();
            foreach($products as $product) {
                $productsData[$product->id] = $product->name;
            }
            //dd($collectionsData);
            return view('admin/collection_form', compact('title', 'collection', 'productsData', 'productCollections'));
        } catch (\Throwable $th) {
            //dd($th->getMessage());
            return redirect('admin/collections')->with('error', $th->getMessage());
        }
    }

    public function save(CollectionRequest $request)
    {
        $post = $request->all();
        $id = $request->get('id');
        try{
            if($id==null) {
                //Add action
                $collection = new Collection;
            }else{
                //edit action
                $collection = Collection::findOrFail($id);
            }
            $collection->name = $post['name'];
            $collection->description = $post['description'];
            if($id==null) {
                //$photo = new Photo;
                $uploadedPhoto = Utility::UploadFile($post['photo'], 'collections', Auth::user()->id);
                if($uploadedPhoto && $uploadedPhoto != null) {
                    $collection->photo = $uploadedPhoto->url;
                }
                $collection->save();
            }else{
                $collection->update();
            }
            $existingProducts = [];
            if($collection->product_collections->count() > 0) {
                foreach($collection->product_collections as $productCollection) {
                    if(!in_array($productCollection->product->id, $post['products'])) {
                        $productCollection->delete();
                    }else{
                        $existingCollections[] = $productCollection->product->id;
                    }
                }
            }
            if(isset($post['products'])) {
                foreach($post['products'] as $product_id) {
                    if(!in_array($product_id, $existingProducts)) {
                        $product_collection = new Product_collection;
                        $product_collection->product_id = $product_id;
                        $product_collection->collection_id = $collection->id;
                        $product_collection->save();
                    }
                }
            }
            if($id==null) {
                return redirect('admin/collections');
            }
            return back()->with("msg", "Collection edited successfully");
        } catch (\Throwable $th) { dd($th);
            echo $th->getMessage();
            //return back()->with('error', $th->getMessage());
        }
    }

    public function change_photo(Request $request)
    {
        $post = $request->all();
        $collection_id = $request->get('id');
        try{
            $collection = Collection::findOrFail($collection_id);
            $uploadedPhoto = Utility::UploadFile($post['photo'], 'collections', Auth::user()->id);
            if($uploadedPhoto && $uploadedPhoto != null) {
                if(!empty($collection->photo)) {
                    unlink('uploads/collections/'.$collection->photo);
                }
                $collection->photo = $uploadedPhoto->url;
                $collection->update();
            }
            return back();
        } catch (\Throwable $th) {
            echo $th->getMessage();
            return back()->with('error', $th->getMessage());
        }
    }

    public function delete($id)
    {
        $collection = Collection::findOrFail($id);
        if($collection) {
            $collection->deleted = 1;
            if($collection->save()) {
                if($collection->product_collections->count() > 0) {
                    foreach($collection->product_collections as $productCollection) {
                        $productCollection->delete();
                    }
                }
            }
        }
        return back();
    }
}
