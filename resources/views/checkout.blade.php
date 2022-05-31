@extends('layouts/public')

<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" id="close-commentModal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(array('url' => "login",'method' => 'post' )) !!}
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <label on="email">Email:</label>
                        <input type="text" name="email" class="form-control" required />
                    </div>
                    <div class="row">
                        <label on="password">Password:</label>
                        <input type="password" name="password" class="form-control" required />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Login" />
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@section('content')
    <!-- Checkout Section Begin -->
    <div class="row" style="padding-left: 4%">
        <section class="checkout spad" style="padding-top:100px;">

            <p id="submitting" class="d-none"><b>...Submitting your order</b></p>

            <div class="row my-4">
                @if(!Auth::user()) 
                    <div class="row">
                        <div class="col-12 my-4">
                            <h6>
                                <span class="icon_tag_alt"></span> Already Have an Account? 
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">
                                    Login
                                </button>
                            </h6>
                        </div>
                    </div>
                @endif
                
                
                <div class="row col-12">
                    <div class="col-lg-8 col-md-8 col-sm-11 row">
                        <h4 class="mb-4">Customer Information @if(!Auth::user()) | Create Account @endif</h4>
                        @include('inc.message');
                        <div class="row col-12  checkout__order">
                            {!! Form::open(['url' => "register",'method' => 'post', 'class'=>'row col-12 checkout__form', ]) !!}
                                <div class="col-6 mb-4">
                                    <p>Name <span>*</span></p>
                                    @if(Auth::user()) {{Auth::user()->name}}
                                    @else
                                        <input type="text" name="name" class="form-control" value="{{old('name')}}" required>
                                    @endif
                                </div>
                                <div class="col-6 mb-4">
                                    <p>Phone <span>*</span></p>
                                    @if(Auth::user()) {{Auth::user()->phone_number}}
                                    @else
                                        <input type="text" name="phone_number" class="form-control"  value="{{old('phone_number')}}" required>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <p>Email <span>*</span></p>
                                    @if(Auth::user()) {{Auth::user()->email}}
                                    @else
                                        <input type="text" name="email" class="form-control"  value="{{old('email')}}" required>
                                    @endif
                                </div>
                                <div class="col-6">
                                    @if(!Auth::user())
                                        <p>Password<span>*</span></p>
                                        <input type="password" name="password" class="form-control"  value="{{old('password')}}" required>
                                    @endif
                                </div>
                                <div class="col-12 mt-4">
                                    @if(!Auth::user())
                                        <input type="submit" class="form-control btn-primary"  value="Submit" />
                                    @endif
                                </div>
                            {!! Form::close() !!}
                        </div>

                        <div class="row mt-4">
                            <h5 class="col-12 mb-2">Delivery Information</h5>
                                @if(Auth::user() && Auth::user()->address)
                                    <div id="customer-address" class="col-12 ml-4">
                                        <p><b>Street Address:</b> {{Auth::user()->address->street_address}}</p>
                                        <p><b>City:</b> {{Auth::user()->address->city}} </p>
                                        <p><b>Country:</b> {{Auth::user()->address->country->name}}</p>
                                    </div>
                                @endif
                                <div id="customer-address-fields" class="col-12 @if(Auth::user() && Auth::user()->address) d-none @endif" >
                                    @include('inc.customer_address_fields')
                                </div>
                                <div class="col-12 mb-5">
                                    <p>Oder notes</p>
                                    <textarea class="form-control" name="notes"></textarea>
                                </div>
                            @if(Auth::user())
                                <button type="submit" class="site-btn" onclick="place_order()">Place oder</button>
                            @endif
                        </div>
                    </div>

                    <div class=" container-fluid col-lg-4 col-12">
                        <div class="row checkout__order">
                            <h5>Your order</h5>
                            <div class="checkout__order__product">
                                <ul id="checkout-cart-products">
                                    <li class="row">
                                        <p class="col-5 text-center">Product</p>
                                        <p class="col-3 text-center">Quantity</p>
                                        <p class="col-4 text-center">Total</p>
                                    </li>
                                    <div id="checkout-cart-products-details">

                                    </div>
                                </ul>
                            </div>
                            <div class="checkout__order__total">
                                <ul id="checkout-cart-total">
                                </ul>
                            </div>
                            <input type="hidden" id="cart-input" name="cart" />
                            @if(Auth::user())
                                <button type="submit" class="site-btn" onclick="place_order()">Place oder</button>
                            @endif
                        </div>
                    </div>
                </div>
                </form>
                
            </div>
        </section>
    
    </div>
   <input type="hidden" name="loggedIn" @if(Auth::user() && Auth::user()->address) value="1" @else value="0" @endif />
        <!-- Checkout Section End -->

@stop

@section('js')
    <script type="application/javascript">
    
        let myCart = localStorage.cart;
        
        $('#cart-input').val(myCart);
        load_checkout_cart();

        function load_checkout_cart()
        {
            let cart = JSON.parse(localStorage.cart);
            let content = "<p>Cart is empty</p>";
            if(cart.length > 0) {
                content = '';
                let total = 0;
                console.log('checkout cart',cart);
                cart.forEach((cartProduct, i) => {
                    let p = product_details(cartProduct);
                    total += p.total;
                    content += `<li class="row">
                                    <p class="col-5 text-center">${cartProduct.name}</p> 
                                    <p class="col-3 d-flex flex-direction-row text-center">
                                        <button type="button" class="py-0 px-2 btn btn-danger btn-sm ${p.display}" onclick="update_checkout_qty('minus', ${cartProduct.id})" style="height:1.5em">-</button>
                                        <span class="mx-1">${cartProduct.quantity}</span>
                                        <button type="button" class="py-0 px-2 btn btn-success btn-sm" onclick="update_checkout_qty('plus', ${cartProduct.id})" style="height:1.5em">+</button>
                                    </p>
                                    <p class="col-4 text-center">
                                        
                                        <span class="currency" data-value="${cartProduct.price}">${p.price}</span>
                                        <span class="currency-sign">${localStorage.currencySign}</span> 
                                    </p>
                                </li>`;
                })
                $('#checkout-cart-products-details').html(content)
                convertedTotal = cart_total(total);
                contentTotal = `<li>Subtotal 
                                <span class="currency" data-value="${total}">${convertedTotal}</span>
                                <span class="currency-sign">${localStorage.currencySign}</span> 
                            </li>
                            <li>Total 
                                <span class="currency" data-value="${total}">${convertedTotal}</span>
                                <span class="currency-sign">${localStorage.currencySign}</span> 
                            </li>`;
                
                $('#checkout-cart-total').html(contentTotal);
            }
        }
        function update_checkout_qty(type, id)
        {
            update_qty(type, id);
            load_checkout_cart();
        }

        function place_order()
        {
            const loggedIn = $('input[name=loggedIn]').val(); 
            let validated = true;
            if(loggedIn==0) {
                validated = validate();
            }
            if(loggedIn==1 || validated) {
                console.log(loggedIn);
                $('#submitting').removeClass('d-none');
                const street_address = $('input[name=street_address]').val();
                const city = $('input[name=city]').val();
                const postal_code = $('input[name=postal_code]').val();
                const country_id = $('select[name=country_id]').val();
                const notes = $('textarea[name=notes]').val();
                const addressDefault = ($('input[name=make_address_default]').prop('checked')) ? 1 : 0; 
                //console.log('address default',addressDefault);

                let url = "{{url('place_order')}}";
                var token = $('meta[name="csrf-token"]').attr('content');
                let cart = JSON.parse(localStorage.cart);
                var productQtys = [];
                var total = 0;
                cart.forEach((cartProduct, i) => {
                    let productDetail = product_details(cartProduct);
                    total += productDetail.total;
                    productQtys.push([cartProduct.id, cartProduct.quantity]);
                });
                var formData =  {cart: productQtys, total, street_address, city, postal_code, country_id, notes, addressDefault, _token: token};
                console.log('formData: ',formData);
                return axios.post(url, formData)
                .then((res) => {
                    $('#submitting').addClass('d-none');
                    let order = res.data.data; 
                    //console.log('invoice no', order.invoice_no);
                    if(res.data.statusCode==200) window.location.href = "{{url('payment')}}/"+order.invoice_no;
                })
                .catch((error) => {
                    $('#submitting').addClass('d-none');
                    console.log("An error occured while trying to set rate "+error.message);
                    throw error;
                });
            }
        }

        function checkEmpty(field)
        {
            console.log(field.name);
            (field.name != 'country_id') ? clearError($(`input[name=${field.name}]`)) : clearError($(`select[name=${field.name}]`));
            //if(field.value != '') clearError(field); 
        }

        function validate()
        {
            var status = true;
            const streetAddr = $('input[name=street_address]'); 
            const city = $('input[name=city]');
            const postalCode = $('input[name=postal_code]');
            const countryId = $('select[name=country_id]');
            let fields = [streetAddr, city, postalCode, countryId];
            
            fields.forEach((field) => {
                if(field.val()=='') {
                    status = false;
                    displayError(field) 
                }
            })
             
            return status;
        }

        function displayError(field)
        {
            field.siblings('span').removeClass('d-none');
            field.css('border', 'medium solid red');
        }

        function clearError(field)
        {
            field.siblings('span').addClass('d-none');
            field.css('border', 'thin solid #000');
        }
    </script>
@stop