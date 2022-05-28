@extends('layouts/public')

@section('content')
 <!-- ====================================================================================================== -->
 <!-- ===NEW PRODUCTS WITH HOVERABLE IMAGES BEGINS ================================================== -->
 <!-- ====================================================================================================== -->
            

<section class="product spad">
    <div class="container-fluid">
        <div class="row mt-5">
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

           
        <div class="row col-11 ml-3 offset-1 property__gallery">
            @if($collection->products->count() > 0)
                @foreach($collection->products as $product)
                    @include('inc.product')
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
