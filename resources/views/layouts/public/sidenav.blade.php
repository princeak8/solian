 <style type="text/css">
    .header__right__widget .dropdown {
        visibility: hidden;
        z-index: 9;
        opacity: 0;
        -webkit-transition: all, 0.3s;
        -o-transition: all, 0.3s;
        transition: all, 0.3s;
    }
    .header__right__widget li:hover .dropdown {
        top: 3px;
        opacity: 1;
        visibility: visible;
    }
    .header__right__widget li .dropdown li {
        display: block;
        margin-top: 0;
        padding-top: 0;
	    margin-right: 0;
    }
    .offcanvas__widget .dropdown {
        visibility: hidden;
        z-index: 9;
        opacity: 0;
        -webkit-transition: all, 0.3s;
        -o-transition: all, 0.3s;
        transition: all, 0.3s;
    }
    .offcanvas__widget li:hover .dropdown {
        top: 3px;
        opacity: 1;
        visibility: visible;
    }
    .offcanvas__widget li .dropdown li {
        display: block;
        margin-top: 0;
        padding-top: 0;
	    margin-right: 0;
    }
 </style>
 <!-- Page Preloder -->
 <div id="preloder">
        <div class="loader"></div>
    </div>

<!-- Shop Cart Section Begin -->

     <!--  MOBILE VIEW Shop Cart Section Begin -->

     <div id="m-cart" class="container mobile-carrt fixed-top" style="width: 20em; font-size: 70%; position: fixed!important; z-index: 10!important;
            background-color: black; opacity:0.9; margin-top: 5em; margin-left: 50%; display:none;"
    >
        <div class="content">
            <p>Cart is empty</p>
        </div>

        <div class="row modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="close_cart('m-cart')">Close</button>
            <a class="btn btn-primary" href="{{url('checkout')}}">Check out</a>
        </div>

    </div>

<!--  MOBILE VIEW Shop Cart Section End -->

    
<!--  DESKTOP VIEW Shop Cart Section BEGINS -->


<div id="d-cart" class="container carrt fixed-top" style="width: 20em; font-size: 70%; position: fixed!important; z-index: 10!important;
    background-color: black; opacity:0.9; margin-left: 83%; margin-top: 5em; display:none;"
>
    <div class="content">
        <p>Cart is empty</p>
    </div>
    <div class="row modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="close_cart('d-cart')">Close</button>
        <a class="btn btn-primary" href="{{url('checkout')}}">Check out</a>
    </div>
 
 </div>
<!--  DESKTOP VIEW Shop Cart Section ENDS -->

 
 
 <!-- Shop Cart Section End -->



    
    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
   
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__close">+</div>
        <ul class="offcanvas__widget">
        <!--
            <li class="pull-right ml-3">
                <a href="#"><span class="fas fa-shopping-cart"></span>
                    <div class="tip">0</div>
                </a>
            </li>
        -->
        @if(!isset($page) || (isset($page) && $page != 'order payment'))
            <li class="pull-right">
                <a href="javascript::void(0)">
                    <span id="m-current-currency" data-currency="{{ Session::get('currency')}}">{{ Session::get('currency')}}</span>
                    <span class="fas fa-caret-down down"></span>
                </a>
                <ul class="dropdown">
                    @foreach($currencies as $currency)
                        <li id="m-{{$currency->name}}" @if($currency->active==1) class="d-none" @endif>
                            <a href="javascript::void(0)" onclick="switch_currency('{{$currency->name}}')">{{$currency->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
            @endif
        </ul>
        <div id="mobile-menu-wrap"></div>
        <!-- <div class="offcanvas__auth">
            <a href="#">Login</a>
            <a href="#">Register</a>
        </div> -->
    </div>
    <!-- Offcanvas Menu End -->
    
    <!-- Header Section Begin -->
    <header class="header fixed-top" style="z-index:5">
        <div class="container-fluid">
            <div class="row">
                
            <div class="col-lg-3">
                    <div class="header__logo row">
                        <a href="{{url('/')}}"><img src="{{asset('assets/img/solian logo.png')}}" alt=""></a>
                        @if(!isset($page) || (isset($page) && $page != 'order payment'))
                        <ul class="offcanvas__widget mobile-carrt">
                                <li>
                                    <a href="javascript:void(0)"><span class="fas fa-shopping-cart" onclick="open_cart('m-cart')"></span>
                                        <span class="tip cart-no">0</span>
                                    </a>
                                </li>
                            </ul> 
                            @endif
                    </div> 
                </div>
                
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul style="display: flex; justify-content: space-around;">
                            <li class="active"><a href="{{url('/')}}">Home</a></li>
                            <li><a href="{{url('collection/'.$newArrivals->name)}}">New Arrivals</a></li>
                            <li><a href="#">Collections<span class="fas fa-caret-down down"></span></a>
                                <ul class="dropdown">
                                    @foreach($collections as $collection)
                                        @if($collection->name != 'New Arrivals')
                                            <li><a href="{{url('collection/'.$collection->name)}}">{{$collection->name}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                            <li class="mr-4"><a href="./contact.html">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                @if(!isset($page) || (isset($page) && $page != 'order payment'))
                <div class="col-lg-3">
                    <div class="header__right">
                        <!-- <div class="header__right__auth">
                            <a href="#">Login</a>
                            <a href="#">Register</a>
                        </div> -->
                        <ul class="header__right__widget" style="min-width:250px; margin-right:20px;">
                            <li>
                                <a href="javascript::void(0)">
                                    <span id="d-current-currency" data-currency="{{ Session::get('currency')}}">{{ Session::get('currency')}}</span>
                                    <span class="fas fa-caret-down down"></span>
                                </a>
                                <ul id="currency-select" class="dropdown">
                                    @foreach($currencies as $currency)
                                        <li id="d-{{$currency->name}}" @if($currency->active==1) class="d-none" @endif>
                                            <a href="javascript::void(0)" onclick="switch_currency('{{$currency->name}}')">{{$currency->name}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><span class="fas fa-shopping-cart" onclick="open_cart('d-cart')"></span>
                                    <div class="tip cart-no">0</div>
                                </a>
                            </li>
                            <!--
                            <li>
                                <a href="#"><span class="icon_heart_alt"></span>
                                    <div class="tip">2</div>
                                </a>
                            </li>
                            -->
                        </ul>
                    </div>
                </div>
                @endif
            </div>
            
            <div class="canvas__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>