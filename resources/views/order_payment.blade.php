@extends('layouts/public', ['page'=>'order payment'])

@section('content')
        <!-- Modal -->
<div class="modal fade" id="bankModal" tabindex="-1" role="dialog" aria-labelledby="bankModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bankModalLabel"> <b>Transaction Details</b></h5>
                <button type="button" id="close-commentModal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(array('url' => "bank",'method' => 'post' )) !!}
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <label on="name">Depositor's Name:</label>
                        <input type="text" name="depositor" class="form-control" required />
                    </div>
                    <div class="row">
                        <label on="name">Amount deposited:</label>
                        <input type="number" name="amount" class="form-control" required />
                    </div>
                    <div class="row">
                        <label on="date">Date of deposit</label>
                        <input type="text" name="date" class="form-control" required />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-sm btn-success" />
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
    <!-- Modal ends -->


    <!-- Checkout Section Begin -->
    <section class="checkout spad">
    <section style="margin-top:2em;">
        <div>
            <div class="row">
                <div class="col-12 my-4">
                    <h6 style="margin-left:40%;"><b>Make Payment</b></h6>
                </div>
            </div>
            @include('inc.message')
            @if(!empty($saved)) <p class="alert alert-success">Your order was saved successfully</p> @endif
            <div class="row">
                <div class="col-12">
                
                        <div class="checkout__order">
                                <h5><b>Order Summary</b></h5>
                                <div class="checkout__order__product my-0" style="border-radius: 2px; background: white;">
                                    <ul id="checkout-cart-products">
                                        <li class="row my-0">
                                            <p class="col-5 text-center"> <b>Product</b></p>
                                            <p class="col-3 text-center"><b>Quantity</b></p>
                                            <p class="col-4 text-center"> <b>Total</b></p>
                                        </li>
                                        <li class="row my-0">
                                            <p class="col-5 text-center"> Ankara</p>
                                            <p class="col-3 text-center">3</p>
                                            <p class="col-4 text-center"> 30000</p>
                                        </li>
                                        <li class="row my-0">
                                            <p class="col-5 text-center"> Solian Gowns</p>
                                            <p class="col-3 text-center">2</p>
                                            <p class="col-4 text-center"> 50000</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="checkout__order__total my-0">
                                    <ul class="row my-0" id="checkout-cart-total">
                                        <li class="col-6 text-center"><b>Total</b></li>
                                        <li class="col-6 text-center"><b>80000</b></li>
                                    </ul>
                                </div>
                                <!-- <div class="row checkout__order__widget">
                                    
                                </div> -->
                        </div>
                
                    <div class="checkout__order">
                        <h5>DELIVERY</h5>

                        <div style="border-radius: 2px; background: white;">
                            <div style="margin-left:1em;">
                                <b>Address Details</b>
                                <p>Elon Mmadu</p>
                                <p>
                                    Suite D6, Goshen Plaza, GRA, Enugu
                                </p>
                                <p>+2348012345678</p>
                            </div>    
                        </div>
                    </div>

                    <div class="checkout__order">
                        <h5>PAYMENT METHOD</h5>
                            <div> 
                                <div style="border-radius: 3px; background: white;">
                                    <div style="padding:1em;">
                                        <input type="radio" name="payment"/><b> Bank Transfer</b>
                                        <p> First Bank of Nigeria</p>
                                        <p> ACC NAME: Solian collections</p> 
                                        <p> ACC NUMBER: 3001230099</p>
                                        <a href="#">
                                            <button class=" btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#bankModal">UPLOAD EVIDENCE OF PAYMENT</button>    
                                        </a>
                                    </div>
                                    
                                </div>
                                
                                <div style="border-radius:3px; background: white; margin-top:2em;">
                                    <div style="padding:1em;">
                                        <input type="radio" name="payment"/> <b>Card Transfer</b>
                                        <br>
                                        <a href="#">
                                            <img src="{{asset('assets/img/paystack-logo.png')}}" style="margin-bottom:3em;"/> 
                                        </a>
                                    </div>
                                </div>
                                
                            </div>
                                
                    </div>

                    
                </div>
            </div>

        </div>
    </section>
    
    <input type="hidden" name="saved" value="{{$saved}}" />

@stop

@section('js')
    <script type="application/javascript">
        saved = $('input[name=saved]').val();
        if(saved == 1) {
            localStorage.removeItem("cart");
        }
    </script>
@stop