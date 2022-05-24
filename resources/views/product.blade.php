@extends('layouts/public')

@section('content')


<!-- Breadcrumb Begin -->
 <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                        <a href="#">Women’s </a>
                        <span>{{$product->name}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product__details__pic">
                        <div class="product__details__slider__content">
                            <div class="product__details__pic__slider owl-carousel">
                                @foreach($product->photos as $photo) 
                                    <img data-hash="product-{{$photo->id}}" class="product__big__img" src="{{$photo->file->url}}" alt="">
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class=" container row">
                        @foreach($product->photos as $photo)
                            <p>{{$photo->id}}</p>
                            <a class="pt mt-2 @if($product->mainId==$photo->id) active @endif" href="#product-{{$photo->id}}">
                                <img src="{{$photo->file->thumb}}" alt="" style="padding:0">
                            </a>
                        @endforeach
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="product__details__text">
                        <h5>{{$product->name}} </h5>
                        <!--
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <span>( 138 reviews )</span>
                        </div>
                        -->
                        <div class="product__details__price">
                            <i class="currency-sign">{{Session::get('currency_sign')}}</i>
                            <i class="currency" data-value="{{$product->price}}">{{number_format($product->new_price, 2)}}</i>
                        </div>
                        <p><?php echo $product->description; ?></p>
                        <div class="product__details__button">
                            <div class="quantity">
                                <span>Quantity:</span>
                                <div class="pro-qty">
                                    <input type="text" name="qty" value="1">
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="cart-btn" onclick="to_cart({{$product}})"><span class="icon_bag_alt"></span> Add to cart</a>
                            <ul>
                                <!--<li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                <li><a href="#"><span class="icon_adjust-horiz"></span></a></li>-->
                            </ul>
                        </div>
                        <div class="product__details__widget">
                            <ul>
                                <li>
                                    <span>Availability:</span>
                                    <div class="stock__checkbox">
                                        <label for="stockin">
                                            In Stock
                                            <!--<input type="checkbox" id="stockin">
                                            <span class="checkmark"></span>-->
                                        </label>
                                    </div>
                                </li>
                                <!--
                                <li>
                                    <span>Available color:</span>
                                    <div class="color__checkbox">
                                        <label for="red">
                                            <input type="radio" name="color__radio" id="red" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label for="black">
                                            <input type="radio" name="color__radio" id="black">
                                            <span class="checkmark black-bg"></span>
                                        </label>
                                        <label for="grey">
                                            <input type="radio" name="color__radio" id="grey">
                                            <span class="checkmark grey-bg"></span>
                                        </label>
                                    </div>
                                </li>
                                -->
                                <li>
                                    <span>Available size:</span>
                                    <div class="size__btn">
                                        @foreach($product->product_sizes as $productSize) 
                                            <label for="xs-btn" class="active">
                                                <input type="radio" id="xs-btn">
                                                {{$productSize->size->size}}
                                            </label>
                                        @endforeach
                                    </div>
                                </li>
                                <!--
                                <li>
                                    <span>Promotions:</span>
                                    <p>Free shipping</p>
                                </li>
                                -->
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Description</a>
                            </li>
                            <!--
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Reviews ( 2 )</a>
                            </li>
                            -->
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <h6>Description</h6>
                                <p><?php echo $product->description; ?></p>
                            </div>
                            <!--
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <h6>Reviews ( 2 )</h6>
                                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                                    quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                                    Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                                    voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                                    consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                                consequat massa quis enim.</p>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                    dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                    nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                quis, sem.</p>
                            </div>
                            -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="related__title">
                        <h5>RELATED PRODUCTS</h5>
                    </div>
                </div>
                @foreach($related as $p)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{asset('uploads/products/'.$p->main)}}">
                            <div class="label new">New</div>
                            <ul class="product__hover">
                                <!--<li><a href="{{asset('uploads/products/'.$p->main)}}" class="image-popup"><span class="arrow_expand"></span></a></li>-->
                                <!--<li><a href="#"><span class="icon_heart_alt"></span></a></li>-->
                                <li><a href="javascript:void(0)" @click="add_to_cart({{$p}})"><span class="icon_bag_alt"></span></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Buttons tweed blazer</a></h6>
                            <!--
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            -->
                            <div class="productprice">
                                <span class="currency-sign">{{Session::get('currency_sign')}}</span>
                                <span class="currency" data-value="{{$product->price}}">{{number_format($p->new_price, 2)}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->
@stop
@section('js')
    <script type="application/javascript">
        $('input[name=qty]').on("input", function() {
            console.log('changed');
        })
        set_qty();
        function set_qty() 
        {
            let cart = JSON.parse(localStorage['cart']);
            let product_id = "{{$product->id}}";
            cart.forEach(function(p, i) {
                if(p.id == product_id) {
                    $('input[name=qty]').val(p.quantity);
                }
            })
        }
        function to_cart(product) {
            let qty = $('input[name=qty]').val();
            remove_item(product.id, false);
            add_to_cart(product, qty);
        }
    //create vue to take the quantity and pass to the add_to cart vue function which in turn calls the global add_to_cart function
    
    var app = new Vue({
		el: '#app',             
		computed: {
			//
		},
		data: {
			qty: 1
        },
        methods: {
            add_to_cart: (product, qty=1) => {
                console.log('Qty: ',qty);
                console.log(product);
                //add_to_cart(product, qty);
            }
        }
    })
    </script>
@stop