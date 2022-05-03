@extends('layouts/admin')

@section('css')
    <style type="text/css">
        .dropbox {
			outline: 2px dashed grey; /* the dash box */
			outline-offset: -10px;
			background: lightcyan;
			color: dimgray;
			padding: 10px 10px;
			min-height: 200px; /* minimum height */
			position: relative;
			cursor: pointer;
		}

		.input-file {
			opacity: 0; /* invisible but it's there! */
			width: 100%;
			height: 200px;
			position: absolute;
			cursor: pointer;
		}
		.dropbox:hover {
			background: lightblue; /* when mouse over to the drop zone, change color */
		}
        .activv, .top-text:hover {
            font-size: 20px;
            margin: 0.5em;
		}
        .top-link{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }
        .top-link-inner{
            display: flex;
            flex-direction: row;
            font-size: 12px;
        }
		.productPhotos img {
            border-radius: 10px;
        }
        
    </style>
@stop

@section('content')

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Products-Gallery 
                <a href="{{url('admin/product/create_photo')}}" class="btn btn-sm btn-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Add Photo
                </a>
            </h6>
                @include('layouts/admin/photos_header')
                <div class="top-link">
                    <div class="top-link-inner" style="display: flex; flex-direction: row;">
                        <span style="display: flex; flex-direction: column;">
                            <a href="#" class="top-text activv" onclick="switchCategory('product')">Add Photo(s) to Product</a>
                         </span>
                        <a href="#" class="top-text ml-5" onclick="switchCategory('slide')">Add Photo(s) to Slides</a>
                    </div>
                    
                    <a href="#" class="btn btn-success btn-sm" onclick="addPhotos()">Save</a>
                </div>
                <select name="product-id">
                    <option value="">Select Product</option>
                    @if($products->count() > 0)
                        @foreach($products as $product) <option value="{{$product->id}}">{{$product->name}}</option> @endforeach
                    @endif
                </select>

        <div class="card-body">
            @include('inc.message')
            <div class="row">
                <p id="loading" class="d-none mb-3" style="height: 4em;"><img src="{{asset('/assets/img/loading-spinner.gif') }}" style="position:absolute; transform: scale(0.5); height:14em; left:40%; top:8.5em; border-radius: 50%;" alt="image"></p>
                <div id="errors" class="d-none">
                    <span class="alert alert-danger"></span>
                </div>
                <div class="mt-5">
                    <h4>Bimpe African Print Dress</h4>
                    <div id="productPhotos" class="row mt-2">
                        <div class="col-md-3 productPhotos">
                            <img src="{{asset('/assets/img/product/product-1.jpg') }}" alt="">
                        </div>
                        <div class="col-md-3 productPhotos">
                            <img src="{{asset('/assets/img/product/product-2.jpg') }}" alt="">
                        </div>
                        <div class="col-md-3 productPhotos">
                            <img src="{{asset('/assets/img/product/product-3.jpg') }}" alt="">
                        </div>
                        <div class="col-md-3 productPhotos">
                            <img src="{{asset('/assets/img/product/product-4.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <h4>Maxi Dress</h4>
                    <div id="productPhotos" class="row mt-2">
                        <div class="col-md-3 productPhotos">
                            <img src="{{asset('/assets/img/product/product-5.jpg') }}" alt="">
                        </div>
                        <div class="col-md-3 productPhotos">
                            <img src="{{asset('/assets/img/product/product-6.jpg') }}" alt="">
                        </div>
                        <div class="col-md-3 productPhotos">
                            <img src="{{asset('/assets/img/product/product-7.jpg') }}" alt="">
                        </div>
                        <div class="col-md-3 productPhotos">
                            <img src="{{asset('/assets/img/product/product-8.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@stop

@section('js')
   
@stop
