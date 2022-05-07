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
        .slidePhotos img {
            border-radius: 10px;
            margin-top: 3em;
        }
        
    </style>
@stop

@section('content')

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
                @include('layouts/admin/photos_header')

        <div class="card-body">
            @include('inc.message')
            <div class="row">
                <p id="loading" class="d-none mb-3" style="height: 4em;"><img src="{{asset('/assets/img/loading-spinner.gif') }}" style="position:absolute; transform: scale(0.5); height:14em; left:40%; top:8.5em; border-radius: 50%;" alt="image"></p>
               
                <div>
                    <h5>Slides</h5>

                    <div id="slidePhotos" class="row mt-2">
                        <div class="col-md-3 slidePhotos">
                                <img src="{{asset('/assets/img/product/product-1.jpg') }}" alt="">
                        </div>
                        <div class="col-md-3 slidePhotos">
                                <img src="{{asset('/assets/img/product/product-2.jpg') }}" alt="">
                        </div>
                        <div class="col-md-3 slidePhotos">
                                <img src="{{asset('/assets/img/product/product-3.jpg') }}" alt="">
                        </div>
                        <div class="col-md-3 slidePhotos">
                                <img src="{{asset('/assets/img/product/product-4.jpg') }}" alt="">
                        </div>
                        <div class="col-md-3 slidePhotos">
                                <img src="{{asset('/assets/img/product/product-1.jpg') }}" alt="">
                        </div>
                        <div class="col-md-3 slidePhotos">
                                <img src="{{asset('/assets/img/product/product-2.jpg') }}" alt="">
                        </div>
                        <div class="col-md-3 slidePhotos">
                                <img src="{{asset('/assets/img/product/product-3.jpg') }}" alt="">
                        </div>
                        <div class="col-md-3 slidePhotos">
                                <img src="{{asset('/assets/img/product/product-4.jpg') }}" alt="">
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
