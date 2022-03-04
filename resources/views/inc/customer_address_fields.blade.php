<div class="col-lg-12">
                                <div class="checkout__form__input">
                                    <p>Address <span>*</span></p>
                                    <input type="text" name="street_address" placeholder="Street Address">
                                </div>
                                <div class="checkout__form__input">
                                    <p>Town/City <span>*</span></p>
                                    <input type="text" name="city" placeholder="Town/City">
                                </div>
                                <div class="checkout__form__input">
                                    <p>Postcode/Zip </p>
                                    <input type="text" name="postal_code" placeholder="postcode/Zip">
                                </div>
                                <div class="checkout__form__input">
                                    <p>Country <span>*</span></p>
                                    <select name="country_id" class="form-control">
                                        <option value="">Select a Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}" @if($country->name=='Nigeria') selected @endif>
                                                {{$country->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="checkout__form__checkbox">
                                    <label for="acc">
                                        Save this delivery Address as my default?
                                        <input type="checkbox" id="acc" name="make_address_default">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>