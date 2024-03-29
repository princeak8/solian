@extends('layouts/public')

@section('content')


<section style="position: relative!important; z-index: 1!important;">
    <div id="carouselExampleFade" class="carousel slide carousel-fade mt-4 pt-5" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($slides as $slide)
                <div class="carousel-item @if($slide->active==1) active @endif">
                    <img class="d-block w-100" src="{{$slide->file->secure_url}}" alt="First slide">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3 col-md-push-3 col-sm-12 col-xs-12">	
                                    <div class="carousel-caption one" style="opacity:0.7;">
                                        <h4>Awesome Outfits:</h4>
                                        <h5>For your memorable occasions</h5>
                                        <!--<p><a  href="#" class="btn btn-sm btn-primary btn-learn">SHOP NOW <i class="icon-arrow-right3"></i> </a></p>-->
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach          
        </div>

        <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
</section>

<!-- IN DESKTOP VIEW Shop Cart Section ENDS -->

<!-- ============== Top Fading Images ends ======================= -->


 <!-- ====================================================================================================== -->
 <!-- ===NEW PRODUCTS WITH HOVERABLE IMAGES BEGINS ================================================== -->
 <!-- ====================================================================================================== -->
            

<section class="product spad">
    <div class="container-fluid">
        <div class="row">
            <div class="justify-content-center">
                <div class="section-title ml-5">
                    <h4>New  product</h4>
                </div>
            </div>
            <!-- <div class="col-lg-8 col-md-8">
                <ul class="filter__controls">
                    <li class="active" data-filter="*">All</li>
                    <li data-filter=".women">Women’s</li>
                    <li data-filter=".men">Men’s</li>
                    <li data-filter=".kid">Kid’s</li>
                    <li data-filter=".accessories">Accessories</li>
                    <li data-filter=".cosmetic">Cosmetics</li>
                </ul>
            </div> -->
        </div>

           
        <div class="row col-11 ml-3 offset-1 property__gallery slider-hero space">
            @if($products->count() > 0)
                @foreach($products as $product)
                    <div class="col-lg-3 col-md-4 col-6 mix women men kid accessories cosmetic">
                        <div class="product__item">
                            <div class="box"><?php $i = 0; ?>
                                @foreach($product->photos as $productPhoto) <?php $i++; ?>
                                    <a href="{{url('product/'.$product->name)}}">
                                        <img @if($i==1) class="lazyload img-back" @else class="lazyload img-front" @endif data-src="{{$productPhoto->file->secure_url}}" 
                                            alt=""
                                        >
                                    </a>
                                    @if($i==2) @break @endif
                                @endforeach
                                <ul class="product__hover">
                                    <li><a href="{{$product->main}}" class="image-popup"><span class="arrow_expand"></span></a></li>
                                    <!--<li><a href="#"><span class="icon_heart_alt"></span></a></li>-->
                                    <li><a href="javascript:void(0)" onclick="add_to_cart({{$product}})"><span class="icon_bag_alt"></span></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="{{url('product/'.$product->name)}}">{{$product->name}}</a></h6>
                                <!--
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                -->
                                
                                    <div class="sizes">
                                        @foreach($product->product_sizes as $productSize) 
                                            @if($productSize->size)
                                                <a href="#">{{$productSize->size->size}}</a>
                                            @endif
                                        @endforeach
                                    </div>
                                
                                <div class="productprice">
                                    <span class="currency-sign">{{Session::get('currency_sign')}}</span>
                                    <span class="currency" data-value="{{$product->price}}">{{number_format($product->new_price, 2)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            
        </div>
    </div>
</section>

             <!-- ====================================================================================================== -->
            <!-- === NEW PRODUCTS WITH HOVERABLE IMAGES  ENDS ================================================== -->
            <!-- ====================================================================================================== -->
       

    <!-- Collection Section Begin -->
    <section class="categories">
        <div class="container-fluid row mb-5">
            @foreach($collections as $collection)
                    <div class="col-6">
                        <div class="content-wrapper">
                            <img class="lazyload" data-src="{{$collection->photo->file->secure_url}}" alt="" style="height: 28em; margin-top:5em;">
                            <div class="text-wrapper">
                                <h2>{{$collection->name}}</h2>
                                <a href="{{url('collection/'.$collection->name)}}" class="btn btn-warning">Shop now</a>
                            </div>
                        </div>
                    </div> 
            @endforeach
        </div>
        
</section>
<!-- Collectgion Section End -->


<!-- ============== FEATURED COLLECTION BEGINS ============================ -->
<!--
<div class="product spad">
    <div class="d-flex justify-content-center">
        <div class="section-title">
            <h4>Featured Collection</h4>
        </div>
    </div>
    
    <div class="container">
        <div class="row slider-hero">
            <div class="col-lg-3 col-md-4 col-6 mix women men kid accessories cosmetic">
                <div class="product__item">
                    <div class="box">
                        <img class="img-back" src="img/product/product-6.jpg " alt="">
                        <img class="img-front" src="img/product/product-5.jpg " alt="">
                        <ul class="product__hover">
                            <li><a href="img/product/product-7.jpg" class="image-popup"><span class="arrow_expand"></span></a></li>
                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                            <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">Contrasting sunglasses</a></h6>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="sizes">
                            <a href="#">S</a>
                            <a href="#">M</a>
                            <a href="#">L</a>
                            <a href="#">XL</a>
                            <a href="#">XXL</a>
                            <a href="#">XXXL</a>
                        </div>
                        <div class="product__price">$ 59.0</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6 mix women men kid accessories cosmetic">
                <div class="product__item">
                    <div class="box">
                        <img class="img-back" src="img/product/product-5.jpg " alt="">
                        <img class="img-front" src="img/product/product-4.jpg " alt="">
                        <ul class="product__hover">
                            <li><a href="img/product/product-7.jpg" class="image-popup"><span class="arrow_expand"></span></a></li>
                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                            <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">Contrasting sunglasses</a></h6>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="product__price">$ 59.0</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6 mix women men kid accessories cosmetic">
                <div class="product__item">
                    <div class="box">
                        <img class="img-back" src="img/product/product-4.jpg " alt="">
                        <img class="img-front" src="img/product/product-3.jpg " alt="">
                        <ul class="product__hover">
                            <li><a href="img/product/product-7.jpg" class="image-popup"><span class="arrow_expand"></span></a></li>
                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                            <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">Contrasting sunglasses</a></h6>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="sizes">
                            <a href="#">S</a>
                            <a href="#">M</a>
                            <a href="#">L</a>
                            <a href="#">XL</a>
                            <a href="#">XXL</a>
                            <a href="#">XXXL</a>
                        </div>
                        <div class="product__price">$ 59.0</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6 mix women men kid accessories cosmetic">
                <div class="product__item">
                    <div class="box">
                        <img class="img-back" src="img/product/product-3.jpg " alt="">
                        <img class="img-front" src="img/product/product-2.jpg " alt="">
                        <ul class="product__hover">
                            <li><a href="img/product/product-7.jpg" class="image-popup"><span class="arrow_expand"></span></a></li>
                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                            <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">Contrasting sunglasses</a></h6>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="sizes">
                            <a href="#">S</a>
                            <a href="#">M</a>
                            <a href="#">L</a>
                            <a href="#">XL</a>
                            <a href="#">XXL</a>
                            <a href="#">XXXL</a>
                        </div>
                        <div class="product__price">$ 59.0</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6 mix women men kid accessories cosmetic">
                <div class="product__item">
                    <div class="box">
                        <img class="img-back" src="img/product/product-3.jpg " alt="">
                        <img class="img-front" src="img/product/product-2.jpg " alt="">
                        <ul class="product__hover">
                            <li><a href="img/product/product-7.jpg" class="image-popup"><span class="arrow_expand"></span></a></li>
                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                            <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">Contrasting sunglasses</a></h6>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="sizes">
                            <a href="#">S</a>
                            <a href="#">M</a>
                            <a href="#">L</a>
                            <a href="#">XL</a>
                            <a href="#">XXL</a>
                            <a href="#">XXXL</a>
                        </div>
                        <div class="product__price">$ 59.0</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6 mix women men kid accessories cosmetic">
                <div class="product__item">
                    <div class="box">
                        <img class="img-back" src="img/product/product-3.jpg " alt="">
                        <img class="img-front" src="img/product/product-2.jpg " alt="">
                        <ul class="product__hover">
                            <li><a href="img/product/product-7.jpg" class="image-popup"><span class="arrow_expand"></span></a></li>
                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                            <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">Contrasting sunglasses</a></h6>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="sizes">
                            <a href="#">S</a>
                            <a href="#">M</a>
                            <a href="#">L</a>
                            <a href="#">XL</a>
                            <a href="#">XXL</a>
                            <a href="#">XXXL</a>
                        </div>
                        <div class="product__price">$ 59.0</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6 mix women men kid accessories cosmetic">
                <div class="product__item">
                    <div class="box">
                        <img class="img-back" src="img/product/product-3.jpg " alt="">
                        <img class="img-front" src="img/product/product-2.jpg " alt="">
                        <ul class="product__hover">
                            <li><a href="img/product/product-7.jpg" class="image-popup"><span class="arrow_expand"></span></a></li>
                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                            <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">Contrasting sunglasses</a></h6>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="sizes">
                            <a href="#">S</a>
                            <a href="#">M</a>
                            <a href="#">L</a>
                            <a href="#">XL</a>
                            <a href="#">XXL</a>
                            <a href="#">XXXL</a>
                        </div>
                        <div class="product__price">$ 59.0</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6 mix women men kid accessories cosmetic">
                <div class="product__item">
                    <div class="box">
                        <img class="img-back" src="img/product/product-3.jpg " alt="">
                        <img class="img-front" src="img/product/product-2.jpg " alt="">
                        <ul class="product__hover">
                            <li><a href="img/product/product-7.jpg" class="image-popup"><span class="arrow_expand"></span></a></li>
                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                            <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">Contrasting sunglasses</a></h6>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="sizes">
                            <a href="#">S</a>
                            <a href="#">M</a>
                            <a href="#">L</a>
                            <a href="#">XL</a>
                            <a href="#">XXL</a>
                            <a href="#">XXXL</a>
                        </div>
                        <div class="product__price">$ 59.0</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6 mix women men kid accessories cosmetic">
                <div class="product__item">
                    <div class="box">
                        <img class="img-back" src="img/product/product-3.jpg " alt="">
                        <img class="img-front" src="img/product/product-2.jpg " alt="">
                        <ul class="product__hover">
                            <li><a href="img/product/product-7.jpg" class="image-popup"><span class="arrow_expand"></span></a></li>
                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                            <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">Contrasting sunglasses</a></h6>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="sizes">
                            <a href="#">S</a>
                            <a href="#">M</a>
                            <a href="#">L</a>
                            <a href="#">XL</a>
                            <a href="#">XXL</a>
                            <a href="#">XXXL</a>
                        </div>
                        <div class="product__price">$ 59.0</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
-->
<!-- ============== FEATURED COLLECTION ENDS ============================ -->


<!-- ============== BLOGS BEGINS ============================ -->
<hr/>
<section class="categories">
    <div class="container-fluid">
        <div class="row home-blog pb-5 mt-5">

            <div class="container-fluid col-6 col-xs-12">
                <img src="{{asset('uploads/company/1010-banner7_1080x.webp')}}" alt="">    
            </div>
            
            <div class="container-fluid col-6 col-xs-12">
                <div class="py-5">
                    <h4 class="mb-4 d-flex justify-content-around">
                        {{$company->name}}
                    </h4>
                    <?php echo $company->about; ?>
                </div>
        </div>
        
    </div>
    
</div>
</section>

@stop
