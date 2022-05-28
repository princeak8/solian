
<!-- Footer Section Begin -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-7">
                <div class="footer__about">
                    <div class="footer__logo">
                        <a href="{{url('/')}}"><img src="{{asset('assets/img/solian logo.png')}}" alt=""></a>
                    </div>
                    <div class="footer__payment">
                        <a href="#"><img src="{{asset('assets/img/payment/payment-1.png')}}" alt=""></a>
                        <a href="#"><img src="{{asset('assets/img/payment/payment-2.png')}}" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                <div class="footer__copyright__text">
                    <p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> Powered by <a href="https://zizix6.com" target="_blank">Zizix6 Tech</a></p>
                </div>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<!-- Search Begin -->
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch">+</div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Search here.....">
        </form>
    </div>
</div>
<!-- Search End -->

<!-- Js Plugins -->
<script src="{{asset('assets/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/js/mixitup.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.countdown.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.slicknav.js')}}"></script>
<script src="{{asset('assets/slick-1.8.1/slick/slick.min.js')}}"></script>
<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.nicescroll.min.js')}}"></script>
<script src="{{asset('assets/js/main.js')}}"></script>
<script src="{{asset('assets/js/slider-main.js')}}"></script>
<script src="{{asset('assets/js/vue.js')}}"></script>  
<script src="{{asset('assets/js/axios.min.js')}}"></script>
<script src="{{asset('assets/js/lodash.js')}}"></script>
<script src="{{asset('assets/js/lazyload.js')}}"></script>
<script type="application/javascript">
    lazyload();
</script>
<script type="application/javascript">
    console.log('working');
    var sessionId = "{{Session::getId()}}";
    console.log(sessionId);
    //console.log('local storage rates', JSON.parse(localStorage.rates));
    //localStorage.rates = '';

    set_rate();
    //localStorage.setItem('cart', []);

    // if(localStorage.sessionId === undefined || localStorage.sessionId != sessionId || localStorage.rates === undefined || _.isEmpty(localStorage.rates)) {
    //     //console.log('no session set', sessionId);
    //     localStorage.sessionId = sessionId;
    //     set_rates();
    //     //console.log(JSON.parse(localStorage.rates));
    // }
    console.log('cart', localStorage['cart']);
    if (!localStorage['cart'])  {
        console.log('cart not set');
        localStorage.setItem('cart', []);
    }

    //set the current currency_sign, currency and rate in the localstorage
    //     let cs = "{{Session::get('currency_sign')}}";
    //     let c = "{{Session::get('currency')}}";
    //     localStorage.setItem('currencySign', cs);
    //     localStorage.setItem('currency', c);
    //     let rates = JSON.parse(localStorage.rates);
    //     let rate = rates[c];
    //     if(c=='NGN' || typeof rates[c]==='undefined'){
    //         rate = 1;
    //     }
    //     localStorage.setItem('conversionRate', rate);
        

    update_cart_section();

    function open_cart(id)
    {
        $('#'+id).css('display', 'block');
    }

    function close_cart(id)
    {
        $('#'+id).css('display', 'none');
    }

    function product_details(p)
    {
        let price = parseFloat(p.price) / localStorage.conversionRate;
        //console.log('price:', price);
        price = parseFloat(price).toFixed(2);
        price = price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        total = price * p.quantity;
        let display = '';
        if(p.quantity <= 1) {
            display = 'd-none';
        }
        return {price: price, total: total, display: display};
    }

    function cart_total(total)
    {
        console.log('total', total);
        //let convertedTotal = localStorage.conversionRate * total;
        //convertedTotal = parseFloat(convertedTotal).toFixed(2);
        convertedTotal = total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        //console.log('converted total', convertedTotal);
        return convertedTotal;
    }

    function load_cart_content(myCart)
    {
        console.log('load');
        let content = '';
        let total = 0;
        if(myCart.length==0) {
            content = "<p>Cart is empty</p>";
        }else{
            myCart.forEach((cartProduct, i) => {
                //console.log('cartProduct', cartProduct);
                let p = product_details(cartProduct);
                console.log('product details', p);
                total += p.total;
                content += `<div class="card mb-2 mt-2">
                                <div class="p-2">
                                    <div class="row">
                                        <!--
                                        <div class="col-md-3">
                                            <span class="cart__product__item">
                                                <img src="{{asset('assets/img/shop-cart/cp-3.jpg')}}" alt="">
                                            </span>
                                        </div>
                                        -->
                                        <div class="col-md-12">
                                            <div class="cart__product__item__title col-12">
                                                <b>${cartProduct.name}</b>
                                            </div>
                                            <div class="col-12>
                                                <span class="cart__price"><b>Price:</b>
                                                    <span class="currency-sign">${localStorage.currencySign}</span> 
                                                    <span class="currency" data-value="${cartProduct.price}">${p.price}</span>
                                                </span> |
                                                <span class="cart__quantity">
                                                    <b>QTY: </b>${cartProduct.quantity}
                                                </span>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">             
                                        <div class="ml-5">
                                            <!--<span class=" ml-2"><a href=""><i class="far fa-heart"></i></a></span>-->
                                            <span class=" ml-2"><a href="javascript:void(0)"><i class="fas fa-trash-alt" onclick="remove_item(${cartProduct.id})"></i></a></span>
                                            <span class="py-0 px-2 btn btn-danger btn-sm ${p.display}" onclick="update_qty('minus', ${cartProduct.id})">-</span>
                                            <span class="py-0 px-2 btn btn-success btn-sm" onclick="update_qty('plus', ${cartProduct.id})">+</span>
                                        </div>        
                                    </div>
                                </div>                                     
                            </div>`;
                
            })

            convertedTotal = cart_total(total);
            content += `<div class="row modal-footer">
                            <div style="color: #FFF;">
                                <b class="mr-5">
                                    TOTAL: 
                                    <span class="currency-sign">${localStorage.currencySign}</span> 
                                    <span class="currency" data-value="${total}">${convertedTotal}</span>
                                </b>
                            </div>
                        </div>`
            //console.log('cart', content);
        }
        $('#d-cart .content').html(content);
        $('#m-cart .content').html(content);
    }
    function update_cart_section()
    {
        
        if (localStorage['cart'])  {
            console.log('update');
            let myCart = JSON.parse(localStorage.cart);
            //console.log('items in cart: ',myCart);
            $('.cart-no').html(myCart.length);
            load_cart_content(myCart);
        }
    }
    //localStorage.removeItem('cart');
    function add_to_cart(product, qty=1)
    {
        //console.log('quantity', qty);
        var productObj = {
            id: product.id,
            name: product.name,
            price: product.price,
            quantity: qty
        };
        
        var cart;
        if (!localStorage['cart'])  {
            console.log('empty');
            cart = [];
            cart.push(productObj);
        }else{ 
            console.log('not empty');
            cart = JSON.parse(localStorage['cart']);
            console.log(localStorage['cart']);
            var productExists = false;
            cart.forEach(function(p, i) {
                if(p.id == productObj.id) {
                    productExists = true;
                    console.log('qty: ',productObj.quantity);
                    console.log('qty2: ',p.quantity);
                    p.quantity = parseInt(p.quantity) + parseInt(productObj.quantity);
                }
            })
            if(!productExists) {
                cart.push(productObj);
            }
        } 
        console.log(cart);
        localStorage.setItem('cart', JSON.stringify(cart));
        update_cart_section();
        //console.log(localStorage.cart);
    }

    function update_qty(type, id)
    {
        let cart = JSON.parse(localStorage['cart']);
        console.log('id: ', id);
        cart.forEach(function(p, i) {
            if(p.id == id) {
                console.log('found');
                if(type=='minus') {
                    p.quantity = parseInt(p.quantity) - 1;
                }
                if(type=='plus') {
                    p.quantity = parseInt(p.quantity) + 1;
                }
            }else{
                console.log('not found');
            }
        })
        localStorage.setItem('cart', JSON.stringify(cart));
        console.log('update qty');
        update_cart_section();
    }

    function remove_item(id, getConfirmation=true)
    {
        let goAhead = false;
        if(getConfirmation) {
            if(confirm('Remove this item from cart?')) {
                goAhead = true;
            }
        }else{
            goAhead = true;
        }

        if(goAhead) {
            let cart = JSON.parse(localStorage['cart']);
            cart.forEach(function(p, i) {
                if(p.id == id) {
                    cart.splice(i, 1);
                }
            })
            localStorage.setItem('cart', JSON.stringify(cart));
            update_cart_section();
        }
        return false;
    }


    async function set_rate()
    {
        let url = "{{url('currency/fetch_rate')}}";
        return axios.get(url)
        .then((res) => { 
            //console.log(res.data);
            let rate = res.data.data;
            localStorage.setItem('currencySign', rate.currency.sign);
            localStorage.setItem('conversionRate', rate.rate);
            console.log('rate set successfully');
        })
        .catch((error) => {
            console.log("An error occured while trying to set rate "+error.message);
            throw error;
        });
    }
    
    function switch_currency(currency)
    {
        var url = "{{url('currency/switch')}}";
        var token = $('meta[name="csrf-token"]').attr('content');
        var formData =  {currency: currency, _token: token};
        return axios.post(url, formData)
            .then((res) => {
                console.log(res.data);
                localStorage.setItem('currencySign', res.data.currencySign);
                localStorage.setItem('conversionRate', res.data.conversionRate);
                console.log('rate2', localStorage.conversionRate);
                //change all the currency symbols to the new currency symbol
                $('.currency-sign').each(function() {
                    $(this).html(res.data.currencySign);
                })
                //convert all the prices to the new price
                $('.currency').each(function() {
                    let val = $(this).data('value');
                    let newVal = parseFloat(val) / res.data.conversionRate;
                    newVal = parseFloat(newVal).toFixed(2);
                    //$(this).data('value', newVal);
                    newVal = newVal.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                    $(this).html(newVal);
                })
                
                currentCurrency = $('#d-current-currency').data('currency');
                $('#d-current-currency').html(currency);
                $('#m-current-currency').html(currency);
                console.log('add class #d-'+currency);
                console.log('remove class #d-'+currentCurrency);
                $('#d-'+currency).addClass('d-none');
                $('#m-'+currency).addClass('d-none');
                $('#d-'+currentCurrency).removeClass('d-none');
                $('#m-'+currentCurrency).removeClass('d-none');
                $('#d-current-currency').data('currency', currency);
                $('#m-current-currency').data('currency', currency);
            })
            .catch((error) => {
                console.log("An error occured while trying to perform the operation "+error.message);
                throw error;
            });
    }

    /*
    var cart = new Vue({
		el: '#cart',       
        created: function() {
            this.cartProducts = JSON.parse(localStorage['cart']);
        }      
		computed: {
			//
		},
		data: {
			cartProducts: [],

        },
        methods: {
            add_to_cart: (product, qty=1) => {
                console.log('Qty: ',qty);
                console.log(product);
                //add_to_cart(product, qty);
            }
        }
    })
    */
</script>
@yield('js')

