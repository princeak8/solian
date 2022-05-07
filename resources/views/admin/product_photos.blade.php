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
        <div class="card-body">
            @include('inc.message')
            <div class="row">
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
