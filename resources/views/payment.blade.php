@extends('layouts/public')

@section('content')

    <p>This is the payment page</p>
    <div class="container-fluid breadcrumb-option">
        <div class="row">
            <div class="col-md-7 col-12 mt-5 payment-left">
                <div class="col-md-8 offset-2 col-12">
                    <div class="link-progress">
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
                    <div>
                        <h5>Bank: First Bank</h5>
                        <h5>Account Name: Lilian Ekueme</h5>
                        <h5>Account Name: 3001234567</h5>
                    </div><hr>
                    <div>
                        <h5>Bank: Zenith Bank</h5>
                        <h5>Account Name: Lilian Ekueme</h5>
                        <h5>Account Name: 2001234567</h5>
                    </div><hr>
                    <div class="upload-evidence">
                        <p>Upload your evidence of payment</p>
                        <form action="/action_page.php">
                            <input type="file" id="myFile" class="btn btn-secondary"name="filename">
                            <input type="submit">
                        </form>
                    </div>
                    <!-- <div class="login-profile">
                            <a href="#"><img src="{{asset('assets/img/product/product-2.jpg')}}" class="thumbnail" style="border-radius: 50%; height: 3em;"alt=""></a>
                        <span class="profile-details">
                            <a href="/"> lilian ekwueme (lilian@email.com)</a>
                            <a href="/"> Log out</a>
                        </span>
                    </div> -->
                    <!-- <h5 class="my-3">Shipping Address</h5> -->

                    <!-- <div class="contact__form">
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
                            <button type="submit" class="site-btn">Continue to Payment</button>
                        </form>
                    </div> -->
                </div>
            </div>
           
            <div class="col-md-5 col-12 mt-5" style="height: 100vh; background-color: WhiteSmoke;">
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
                    <!-- <div class="contact__form">
                        <form action="#">
                            <input type="text" class="w-50" placeholder="Gift Card/ Discount Voucher">
                            <span class="btn btn-secondary">Apply</span>
                        </form>
                    </div> <hr> -->
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