@extends('layouts/public', ['page'=>'index'])

@section('css')
 <style type="text/css">
    .carousel-item img{
            display: none;
         }
</style>

@stop

@section('content')


<section style="position: relative!important; z-index: 1!important;">
    <div id="carouselExampleFade" class="carousel slide carousel-fade mt-4 pt-5" data-ride="carousel" >
        <div class="carousel-inner">
            @if($slides->count() > 0) {
                @foreach($slides as $slide)
                    <div class="carousel-item @if($slide->active==1) active @endif">
                        <img class="d-block w-100" src="{{$slide->file->FileUrl}}" alt="First slide">
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
            @else
                <img class="d-block w-100" src="{{asset('images/slides/timely-group-photos-2-1400x800-1400x800-c-default-20210308154209.jpg')}}" />
            @endif 
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
        <!-- <div class="row">
            <div class="justify-content-center">
                <div class="section-title ml-5">
                    <h4>New  product</h4>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <ul class="filter__controls">
                    <li class="active" data-filter="*">All</li>
                    <li data-filter=".women">Women’s</li>
                    <li data-filter=".men">Men’s</li>
                    <li data-filter=".kid">Kid’s</li>
                    <li data-filter=".accessories">Accessories</li>
                    <li data-filter=".cosmetic">Cosmetics</li>
                </ul>
            </div>
        </div> -->

        <div>
            @if($newArrivals->products && $newArrivals->products->count() > 0)
                @include('inc.new_arrivals')
            @endif
            
            @foreach($collections as $collection)
                @if($collection->products->count() > 0)
                    <div class="section-title ml-3">
                        <h4>{{strtoupper($collection->name)}} Collection</h4>
                    </div>
                    <div class="row property__gallery space ml-3" style="display: flex; justify-content: center;"> 
                    
                        @foreach($collection->products as $product)
                            @include('inc.product')
                        @endforeach
                    </div>
                @endif
                
            @endforeach
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
                    <div class="col-md-6 col-12">
                        <div class="content-wrapper" style="display: flex; justify-content: center;" class="mb-1">
                            <img class="lazyload" data-src="{{$collection->image}}" alt="" style="height: 28em; margin: 3em 3em;">     
                        </div>
                        <div class="text-center" style="border: solid thin #000;">
                            <span class="text-underline"><h5 class="text-underline">{{$collection->name}}</h5></span>
                            <br/><br/>
                            <a href="{{url('collection/'.$collection->name)}}" class="btn btn-warning">Shop now</a>
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
                <img src="{{asset('uploads/company/fashion-photographer-reading-berkshire-large-1400x800-20210308154131.jpg')}}" alt="">    
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
