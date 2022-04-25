
<!-- Footer Section Begin -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-7">
                <div class="footer__about">
                    <div class="footer__logo">
                        <a href="./index.html"><img src="{{asset('assets/img/logo.png')}}" alt=""></a>
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
    if(localStorage.sessionId === undefined || localStorage.sessionId != sessionId || localStorage.rates === undefined || _.isEmpty(localStorage.rates)) {
        //console.log('no session set', sessionId);
        localStorage.sessionId = sessionId;
        set_rates();
        //console.log(JSON.parse(localStorage.rates));
    }
    
    if (!localStorage['cart'])  {
        localStorage.setItem('cart', []);
    }

    //set the current currency_sign, currency and rate in the localstorage
        let cs = "{{Session::get('currency_sign')}}";
        let c = "{{Session::get('currency')}}";
        localStorage.setItem('currencySign', cs);
        localStorage.setItem('currency', c);
        let rates = JSON.parse(localStorage.rates);
        let rate = rates[c];
        if(c=='NGN' || typeof rates[c]==='undefined'){
            rate = 1;
        }
        localStorage.setItem('conversionRate', rate);
        

    update_cart_section();

    function open_cart(id)
    {
        $('#'+id).css('display', 'block');
    }

    function close_cart(id)
    {
        $('#'+id).css('display', 'none');
    }

    function product_details(p, total)
    {
        let price = localStorage.conversionRate * parseFloat(p.price);
        //console.log('price:', localStorage.conversionRate);
        price = parseFloat(price).toFixed(2);
        price = price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        total = total + (parseFloat(p.price) * p.quantity);
        let display = '';
        if(p.quantity <= 1) {
            display = 'd-none';
        }
        return {price: price, total: total, display: display};
    }

    function cart_total(total)
    {
        let convertedTotal = localStorage.conversionRate * total;
        convertedTotal = parseFloat(convertedTotal).toFixed(2);
        convertedTotal = convertedTotal.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
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
                let p = product_details(cartProduct, total);
                total = p.total;
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
            //console.log('items in cart: ',cart.length);
            $('.cart-no').html(myCart.length);
            load_cart_content(myCart);
        }
    }
    //localStorage.removeItem('cart');
    function add_to_cart(product, qty=1)
    {
        console.log('quantity', qty);
        var productObj = {
            id: product.id,
            name: product.name,
            price: product.price,
            quantity: qty
        };
        
        var cart;
        if (!localStorage['cart'])  {
            cart = [];
            cart.push(productObj);
        }else{ 
            cart = JSON.parse(localStorage['cart']);
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

        localStorage.setItem('cart', JSON.stringify(cart));
        update_cart_section();
        //console.log(localStorage.cart);
    }

    function update_qty(type, id)
    {
        let cart = JSON.parse(localStorage['cart']);
        cart.forEach(function(p, i) {
            if(p.id == id) {
                if(type=='minus') {
                    p.quantity = parseInt(p.quantity) - 1;
                }
                if(type=='plus') {
                    p.quantity = parseInt(p.quantity) + 1;
                }
            }
        })
        localStorage.setItem('cart', JSON.stringify(cart));
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

    async function fetch_currencies()
    {
        let url = "{{url('currency/fetch_currencies')}}";
        return axios.get(url)
        .then((res) => { 
            //console.log(res.data);
            let currencies = [];
            res.data.currencies.forEach((currency, i) => {
                if(currency.active == 0) {
                    currencies.push(currency.name);
                }
            })
            return currencies;
        })
        .catch((error) => {
            console.log("An error occured while trying to perform the operation "+error.message);
            throw error;
        });
    }
    
    async function fetch_rate(curr, n=0)
    { 
        var ApiUrl = `https://free.currconv.com/api/v7/convert?q=NGN_${curr}&compact=ultra&apiKey=80d4f3513c5fb7986ef4`;
        return axios.get(ApiUrl)
        .then((res) => { 
            //console.log(curr+ ': '+res.data['NGN_'+curr]);
            return res.data['NGN_'+curr];
            //localStorage.rates = JSON.stringify(rates);
            //console.log(JSON.parse(localStorage.rates).USD);
        })
        .catch((error) => {
            console.log("An error occured while trying to perform the operation "+error.message);
            if(n<3) { n = n+1;
                fetch_rate(curr, n);
                console.log('errorNo: ',n)
            }
            throw error;
        });
    }
    async function fetch_dbrate(curr, n=0)
    { 
        console.log('db rate function');
        n = n+1;
        var ApiUrl = `{{url('currency/fetch_rate')}}/${curr}`;
        return axios.get(ApiUrl)
        .then((res) => { 
            if(res.data.status==200) {
                console.log(res.data.rate);
                return res.data.rate;
            }else{
                console.log('error: ',res.data.message);
            }
        })
        .catch((error) => {
            console.log("An error occured while trying to perform the operation "+error.message);
            if(n<5) {
                fetch_dbrate(curr, n);
            }else{
                throw error;
            }
        });
    }
    async function get_rates()
    {
        var currencies = await fetch_currencies();//['USD', 'EUR', 'GBP'];
        rates = {};
        let result;
        let promises = [];
        var n = currencies.length; 
        for(let i = 0; i < currencies.length; i++) {  
            //promises.push(fetch_rate(currencies[i]));
            try{
                rate = await fetch_rate(currencies[i]);
                console.log('rate from API: ', rate);
            }catch(e) {
                rate = await fetch_dbrate(currencies[i]);
                console.log('rate from db: ', rate);
            }
            //console.log(rate);
            rates[currencies[i]] = rate;
        }
        //result = await Promise.all(promises);
        //console.log('result ',result);
        /*for(let i = 0; i < currencies.length; i++) { 
            rates[currencies[i]] = result[i];
        }*/
        localStorage.rates = JSON.stringify(rates);
        return localStorage.rates;
    }
    
    async function set_rates()
    {
        let rates = await get_rates();
        console.log('rates: ',rates);
        //console.log('rates ',JSON.parse(rates));
        let url = "{{url('currency/set_rates')}}";
        let token = $('meta[name="csrf-token"]').attr('content');
        let storageRates = JSON.parse(localStorage.rates);
        let formData =  {rates: rates, _token: token};
        let currency = localStorage.currency;
        localStorage.setItem('conversionRate', storageRates['USD']);
        console.log('storage rate: ',storageRates);
        
        console.log('rate3',storageRates['USD']);
        axios.post(url, formData)
        .then((res) => {
            console.log('set rate: ', res.data);
        })
        .catch((error) => {
            console.log("An error occured while trying to perform the operation "+error.message);
            throw error;
        });
    }
    //console.log(localStorage);
    /*Array.from(localStorage.rates).forEach((rate, i) => {
        console.log(rate);
    })*/   
    
    function switch_currency(currency)
    {
        var url = "{{url('currency/switch')}}";
        var token = $('meta[name="csrf-token"]').attr('content');
        var formData =  {currency: currency, _token: token};
        return axios.post(url, formData)
            .then((res) => {
                console.log(res.data);
                localStorage.setItem('currency', res.data.currencySign);
                localStorage.setItem('conversionRate', res.data.conversionRate);
                console.log('rate2', localStorage.conversionRate);
                //change all the currency symbols to the new currency symbol
                $('.currency-sign').each(function() {
                    $(this).html(res.data.currencySign);
                })
                //convert all the prices to the new price
                $('.currency').each(function() {
                    let val = $(this).data('value');
                    let newVal = res.data.conversionRate * parseFloat(val);
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

