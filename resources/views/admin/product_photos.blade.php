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
        .icons {
            transform: scale(1.5);
            margin: 1em;
        }
        .fa-trash {
            color: red;
        }
        
    </style>
@stop

@section('content')

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
                @include('layouts/admin/photos_header')
                <div class="top-link">
                <div class="top-link-inner" style="display: flex; flex-direction: row;">
                    <span style="display: flex; flex-direction: column;">
                        <a href="javascript:void(0)" class="top-text activv" onclick="switchCategory('collection')">Add Photo(s) to Collection</a>
                    </span>
                    <a href="javascript:void(0)" class="top-text ml-5" onclick="switchCategory('slide')">Add Photo(s) to Slide</a>
                </div>
                <a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="addPhotos()">Save</a>
            </div>
          
        <div class="card-body">
            @include('inc.message')
            <div class="row">
                <div class="mt-5">
                    <h4>Bimpe African Print Dress</h4>
                    <div id="productPhotos" class="row mt-2">
                        <div class="col-md-3 productPhotos">
                            <img src="{{asset('/assets/img/product/product-1.jpg') }}" alt="">
                            <div class="container" style="display: flex; justify-content: space-around; padding-right:2em; padding-left:2em">
                                <span class="icons">
                                    <input type="checkbox" id="" class="checkbox" name="" value="${photo.file}" data-thumb=",${photo.thumb}" data-url="${photo.url}" data-size="${photo.size}">
                                </span>
                                <span class="icons">
                                    <a href="#"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 productPhotos">
                            <img src="{{asset('/assets/img/product/product-2.jpg') }}" alt="">
                            <div class="container" style="display: flex; justify-content: space-around; padding-right:2em; padding-left:2em">
                                <span class="icons">
                                    <input type="checkbox" id="" class="checkbox" name="" value="${photo.file}" data-thumb=",${photo.thumb}" data-url="${photo.url}" data-size="${photo.size}">
                                </span>
                                <span class="icons">
                                    <a href="#"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 productPhotos">
                            <img src="{{asset('/assets/img/product/product-3.jpg') }}" alt="">
                            <div class="container" style="display: flex; justify-content: space-around; padding-right:2em; padding-left:2em">
                                <span class="icons">
                                    <input type="checkbox" id="" class="checkbox" name="" value="${photo.file}" data-thumb=",${photo.thumb}" data-url="${photo.url}" data-size="${photo.size}">
                                </span>
                                <span class="icons">
                                    <a href="#"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 productPhotos">
                            <img src="{{asset('/assets/img/product/product-4.jpg') }}" alt="">
                            <div class="container" style="display: flex; justify-content: space-around; padding-right:2em; padding-left:2em">
                                <span class="icons">
                                    <input type="checkbox" id="" class="checkbox" name="" value="${photo.file}" data-thumb=",${photo.thumb}" data-url="${photo.url}" data-size="${photo.size}">
                                </span>
                                <span class="icons">
                                    <a href="#"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </span>
                            </div>
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
    <input type="text" name="category" value="product"/>

</div>
<!-- /.container-fluid -->
@stop

@section('js')
   
@stop
