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
            console.log('fetched rate', res);
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
    async function get_rates()
    {
        rates = {};
        let result;
        let url = "{{url('currency/fetch_rates')}}";
        return axios.get(url)
        .then((res) => { 
            let rates = res.data.data;
            //console.log(rates);
            return rates;
        })
        .catch((error) => {
            console.log("An error occured while trying to fetch rates "+error.message);
            throw error;
        });
        //result = await Promise.all(promises);
        //console.log('result ',result);
        /*for(let i = 0; i < currencies.length; i++) { 
            rates[currencies[i]] = result[i];
        }*/
        // localStorage.rates = JSON.stringify(rates);
        // return localStorage.rates;
    }
    
    async function set_rates()
    {
        let rates = await get_rates();
        console.log('rates: ',rates.data.data);
        var storageRates = {};
        if(rates.length > 0) {
            rates.forEach((rate) => {
                storageRates[rate.currency.name] = rate.rate;
            })
        }
        //console.log('rates ',JSON.parse(rates));
        // let url = "{{url('currency/set_rates')}}";
        // let token = $('meta[name="csrf-token"]').attr('content');
        // let storageRates = JSON.parse(localStorage.rates);
        // let formData =  {rates: rates, _token: token};
        // let currency = localStorage.currency;
        // localStorage.setItem('conversionRate', storageRates['USD']);
        // console.log('storage rate: ',storageRates);
        
        // console.log('rate3',storageRates['USD']);
        // axios.post(url, formData)
        // .then((res) => {
        //     console.log('set rate: ', res.data);
        // })
        // .catch((error) => {
        //     console.log("An error occured while trying to perform the operation "+error.message);
        //     throw error;
        // });
    }
    //console.log(localStorage);
    /*Array.from(localStorage.rates).forEach((rate, i) => {
        console.log(rate);
    })*/   