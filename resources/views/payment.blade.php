@extends('layouts/public')

@section('content')

    <div class="mt-4" style="margin-top: 5em;">
        <div class="row" style="margin-top: 5em;">

            <div class="col-md-6 col-12 mt-5 payment-left">
                <div class="col-md-8 offset-2 col-12">
                    <div class="link-progress breadcrumb-option">
                        <a href="/">Checkout</a>
                        <i class="fas fa-greater-than fa-sm"></i>
                        <h5>Payment</h5>
                    </div>
                    <div class="card-payment">
                        <h5 style="display:flex; justify-content: center; margin-bottom: 1em;">Card Payment</h5>
                        <div class="payment-links">
                            <a href="#"><img src="{{asset('assets/img/payment/payment-1.png')}}" alt=""></a>
                            <a href="#"><img src="{{asset('assets/img/payment/payment-2.png')}}" alt=""></a>
                        </div>
                    </div>
                    <div class="bank-transfer">
                        <h5><span>Or</span></h5>
                    </div>
                    <h4 class="section-title">Bank Transfer</h4><hr>
                    @if($bankAccounts->count() > 0)
                        @foreach($bankAccounts as $account)
                            <div>
                                <p><b>Bank:</b> {{$account->bank->name}}</p>
                                <p><b>Account Name:</b> {{$account->name}}</p>
                                <p><b>Account Name:</b> {{$account->number}}</p>
                            </div><hr>
                        @endforeach
                    @else
                        <p>Sorry No Account available at the moment. Please contact {{$companyInfo->phone_numbers}} for account to make payment to
                    @endif

                    <div class="upload-evidence">
                        <p>Upload your evidence of payment</p>
                        <form action="/action_page.php">
                            <input type="file" id="myFile" class="btn btn-secondary"name="filename">
                            <input type="submit">
                        </form>
                    </div>
                    
                </div>
            </div>
           

            <div class="row container-fluid col-md-6 col-12" style="margin-top: 5em;">
                <div class="checkout__order col-12">
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
                                <button type="submit" class="site-btn" onclick="place_order()">Proceed to Payment</button>
                            @endif
                        </div>
                    </div>



            
               
            </div>
        </div>
    </div>

@stop

@section('js')
    <script type="application/javascript">
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
    </script>
@stop