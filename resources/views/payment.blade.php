@extends('layouts/public')

@section('content')

    <div class="container breadcrumb-option">
        <div class="row">
            <div class="col-md-7 col-12 mt-5 payment-left">
                <div class="col-md-8 offset-2 col-12">
                    <div class="link-progress">
                        <a href="/">Checkout</a>
                        <i class="fas fa-greater-than fa-sm"></i>
                        <h5>Payment</h5>
                    </div>

                    <div class="mb-4">
                        <h4>
                            INVOICE #{{$order->invoice_no}} 
                            (<span class="@if($order->paymentStatus->status=='paid')alert-success @endif @if($order->paymentStatus->status=='unpaid') alert-danger @endif">
                                {{$order->paymentStatus->status}}
                            </span>)
                        </h4>
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
                    @if($order->orderProducts->count() > 0)
                        @foreach($order->orderProducts as $orderProduct)
                            <div class="row pt-5">
                                <div class="col-md-2">
                                    <a href="#"><img src="{{$orderProduct->product->Mainthumb}}" class="thumbnail" style="height: 5em;"alt=""></a>
                                </div>
                                <div class="col-md-7">
                                    <h6 style="font-weight: bold;">{{$orderProduct->product->name}}</h6>
                                </div>
                                <div class="col-md-3" style="font-weight: bold;">{{$orderProduct->order->currency->sign}}{{number_format($orderProduct->price)}}</div>
                            </div> <hr>
                        @endforeach
                    @endif
                    <!-- <div class="contact__form">
                        <form action="#">
                            <input type="text" class="w-50" placeholder="Gift Card/ Discount Voucher">
                            <span class="btn btn-secondary">Apply</span>
                        </form>
                    </div> <hr> -->
                    <div>
                        <div style="display: flex; justify-content: space-between">
                            <span>Subtotal</span>
                            <span>{{$orderProduct->order->currency->sign}}{{number_format($order->total)}}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <span>Shipping</span>
                            <span>{{$orderProduct->order->currency->sign}}0</span>
                        </div>
                    </div> <hr>
                    <div style="display: flex; justify-content: space-between">
                            <span>Total</span>
                            <h5 style="font-weight: bold;">{{$orderProduct->order->currency->sign}}{{number_format($order->total)}}</h5>
                    </div>
                </div>
               
            </div>
        </div>
    </div>

@stop