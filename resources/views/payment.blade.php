@extends('layouts/public')

@section('content')

    <p>This is the payment page</p>
    <div class="container-fluid breadcrumb-option">
        <div class="row">
            <div class="col-md-6 col-12 mt-5 payment-wrapper" style="display: flex; flex-direction: column;">
                <div class="link-progress" style="display: block;">
                    <span>Information</span>
                    <i class='fas fa-greater-than fa-sm'></i>
                    <span>Shipping</span>
                    <i class='fas fa-greater-than fa-sm'></i>
                    <span>Payment</span>
                </div>
                <div class="express-checkout">
                    <h5>Express Checkout</h5>
                    <div class="payment-links">
                        <a href="#"><img src="{{asset('assets/img/payment/payment-1.png')}}" alt=""></a>
                        <a href="#"><img src="{{asset('assets/img/payment/payment-2.png')}}" alt=""></a>
                    </div>
                </div>
                <div class="contact-checkout">
                    <h5><span>Or</span></h5>
                </div>
                <h4>Contact Information</h4>
                <div style="display: flex;">
                    <span>
                        <a href="#"><img src="{{asset('assets/img/product/product-2.jpg')}}" class="thumbnail" style="border-radius: 50%; height: 3em;"alt=""></a>
                    </span>
                    <span>
                        <p> lilian ekwueme (lilian@email.com)</p>
                        <p> Log out</p>
                    </span>
                </div>
                <h5 class="my-3">Shipping Address</h5>

                <div  class="contact__form">
                    <form action="#">
                        <input type="text" name="savedAddress" placeholder="Saved Address">
                        <input type="number" name="phoneNumber" placeholder="Phone number">
                        <span style="display:flex; justify-content: space between;">
                            <input type="text" name="firstName" placeholder="First Name"class="mr-3 w-75;">
                            <input type="text" name="lastName" placeholder="Last Name"class="w-75;">
                        </span>
                        <textarea  name="address" placeholder="Address"></textarea>
                        <input type="text" name="city" placeholder="City">
                        <span style="display:flex; justify-content: space between;">
                            <input type="text" name="country" placeholder="Country"class="mr-3 w-25;">
                            <input type="text" name="state" placeholder="State"class="mr-3 w-25;">
                            <input type="text" name="zipcode" placeholder="Zipcode"class="w-25;">
                        </span>
                        <button type="submit" class="site-btn">Continue to shipping</button>
                    </form>
                </div>
               
                
            </div>
            <div class="col-md-6 col-12 mt-5" style="height: 100vh; background-color: WhiteSmoke;">
                <div class="container payment-right">
                    <div class="row pt-5">
                        <div class="col-md-2">
                            <a href="#"><img src="{{asset('assets/img/product/product-2.jpg')}}" class="thumbnail" style="height: 5em;"alt=""></a>
                        </div>
                        <div class="col-md-7">
                            <h6 style="font-weight: bold;">LAGOS MAXI DRESS</h6>
                            <span style="font-size: 12px;">XL</span> 
                        </div>
                        <div class="col-md-3" style="font-weight: bold;">$100</div>
                    </div> <hr>
                    <div>
                        <span>
                            <input type="text" class="w-75" placeholder="Gift Card/ Discount Voucher">
                            <span class="btn btn-secondary">Apply</span>
                        </span>
                    </div> <hr>
                    <div>
                        <div style="display: flex; justify-content: space-between">
                            <span>Subtotal</span>
                            <span>$100.00</span>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <span>Shipping</span>
                            <span>Calculated in the next step</span>
                        </div>
                    </div> <hr>
                    <div style="display: flex; justify-content: space-between">
                            <span>Total</span>
                            <h5 style="font-weight: bold;">$100.00</h5>
                    </div>


                </div>
               
            </div>
        </div>
    </div>

@stop