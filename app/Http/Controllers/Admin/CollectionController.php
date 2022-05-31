<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

use App\Http\Requests\CollectionRequest;

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
                $collection = $this->collectionService->collection();
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
        dd('here');
        // $post = $request->all();
        // $post['id'] = $request->get('id');
        // try{
        //     $this->collectionService->save($post);
        //     if($post['id']==null) {
        //         return redirect('admin/collections');
        //     }
        //     return back()->with("msg", "Collection edited successfully");
        // } catch (\Throwable $th) { dd($th);
        //     echo $th->getMessage();
        //     //return back()->with('error', $th->getMessage());
        // }
    }

    // public function change_photo(Request $request)
    // {
    //     $post = $request->all();
    //     $collection_id = $request->get('id');
    //     try{
    //         $collection = Collection::findOrFail($collection_id);
    //         $uploadedPhoto = Utility::UploadFile($post['photo'], 'collections', Auth::user()->id);
    //         if($uploadedPhoto && $uploadedPhoto != null) {
    //             if(!empty($collection->photo)) {
    //                 unlink('uploads/collections/'.$collection->photo);
    //             }
    //             $collection->photo = $uploadedPhoto->url;
    //             $collection->update();
    //         }
    //         return back();
    //     } catch (\Throwable $th) {
    //         echo $th->getMessage();
    //         return back()->with('error', $th->getMessage());
    //     }
    // }

    // public function delete($id)
    // {
    //     $collection = Collection::findOrFail($id);
    //     if($collection) {
    //         $collection->deleted = 1;
    //         if($collection->save()) {
    //             if($collection->product_collections->count() > 0) {
    //                 foreach($collection->product_collections as $productCollection) {
    //                     $productCollection->delete();
    //                 }
    //             }
    //         }
    //     }
    //     return back();
    // }
}
