<div class="col-lg-3 col-md-4 col-6 mix women men kid accessories cosmetic">
    <div class="product__item">
        <div class="box"><?php $i = 0; ?>
            @if($product->photos->count() > 0)
                @foreach($product->photos as $productPhoto) <?php $i++; ?>
                    <a href="{{url('product/'.$product->name)}}">
                        <img @if($i==1) class="lazyload img-back" @else class="lazyload img-front" @endif data-src="{{$productPhoto->file->thumb}}" alt="">
                    </a>
                    @if($i==2) @break @endif
                @endforeach
            @else
                <img class="lazyload img-back" data-src="{{$product->mainThumb}}" />
            @endif
            <ul class="product__hover">
                <li><a href="{{$product->main}}" class="image-popup"><span class="arrow_expand"></span></a></li>
                <!--<li><a href="#"><span class="icon_heart_alt"></span></a></li>-->
                <?php $product->photo = $product->mainThumb; ?>
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
                <span class="currency-sign">{{$baseCurrency->sign}}</span>
                <span class="currency" data-value="{{$product->price}}">{{number_format($product->converted_price, 2)}}</span>
            </div>
        </div>
    </div>
</div>