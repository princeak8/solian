<div class="row col-lg-12">
    <div class="col-6 mb-4">
        <div class="checkout__form__input">
            <span class="alert-danger d-none">Please enter your street address</span>
            <p>Address <span>*</span></p>
            <input type="text" name="street_address" placeholder="Street Address" class="form-control" required onblur="checkEmpty(this)">
        </div>
        <div class="checkout__form__input">
            <span class="alert-danger d-none">Please enter the name of your city</span>
            <p>Town/City <span>*</span></p>
            <input type="text" name="city" placeholder="Town/City" class="form-control" required onblur="checkEmpty(this)">
        </div>
    </div>
    <div class="col-6 mb-4">
        <div class="checkout__form__input">
            <span class="alert-danger d-none">Enter your postal code</span>
            <p>Postcode/Zip </p>
            <input type="text" name="postal_code" placeholder="postcode/Zip" class="form-control" required onblur="checkEmpty(this)">
        </div>
        <div class="checkout__form__input">
            <span class="alert-danger d-none">Please Choose your country</span>
            <p>Country <span>*</span></p>
            <select name="country_id" class="form-control" required onblur="checkEmpty(this)">
                <option value="">Select a Country</option>
                @foreach($countries as $country)
                    <option value="{{$country->id}}" @if($country->name=='Nigeria') selected @endif>
                        {{$country->name}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="checkout__form__checkbox">
        <label for="acc">
            Save this delivery Address as my default?
            <input type="checkbox" id="acc" name="make_address_default" value="1">
            <span class="checkmark"></span>
        </label>
    </div>
</div>