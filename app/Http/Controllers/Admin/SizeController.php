<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Utility\SizeService;

class SizeController extends Controller
{
    private $sizeService;

    public function __construct()
    {
        $this->middleware('adminAuth');
        $this->sizeService = new SizeService;
    }

    public function index()
    {
        $size_types = $this->sizeService->sizeTypes();
        $sizes = $this->sizeService->sizes();
        return view('admin/sizes', compact('size_types', 'sizes'));
    }

    public function edit($id)
    {
        $size_range = $this->sizeService->sizeRange($id);
        return view('admin/edit_size', compact('size_range'));
    }

    public function update(Request $request)
    {
        $post = $request->all();
        $id = $request->get('id');
        try{
            $size_range = $this->sizeService->sizeRange($id);
            if($size_range) {
                $this->sizeService->updateSizeRange($size_range, $post);
                return back()->with("msg", "Size Range Updated successfully");
            }else{
                return back()->with('error', 'Size Range not found');
            }
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
