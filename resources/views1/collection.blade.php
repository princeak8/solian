@extends('layouts/public')

@section('content')
 <!-- ====================================================================================================== -->
 <!-- ===NEW PRODUCTS WITH HOVERABLE IMAGES BEGINS ================================================== -->
 <!-- ====================================================================================================== -->
            

<section class="product spad">
    <div class="container-fluid">
        <div class="row">
            <div class="justify-content-center">
                <div class="section-title ml-5">
                    <h4>{{$collection->name}}</h4>
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

           
        <div class="row col-11 ml-3 offset-1 property__gallery slider-hero">
            @if($collection->products->count() > 0)
                @foreach($collection->products as $product)
                    <div class="col-lg-3 col-md-4 col-6 mix women men kid accessories cosmetic">
                        <div class="product__item">
                            <div class="box"><?php $i = 0; ?>
                                @foreach($product->photos as $productPhoto) <?php $i++; ?>
                                    <a href="{{url('product/'.$product->name)}}">
                                        <img @if($i==1) class="lazyload img-back" @else class="lazyload img-front" @endif data-src="{{asset('uploads/products/'.$productPhoto->name)}}" 
                                            alt=""
                                        >
                                    </a>
                                    @if($i==2) @break @endif
                                @endforeach
                                <ul class="product__hover">
                                    <li><a href="{{asset('uploads/products/'.$product->main)}}" class="image-popup"><span class="arrow_expand"></span></a></li>
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
                                        <a href="#">{{$productSize->size->size}}</a>
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

@stop
