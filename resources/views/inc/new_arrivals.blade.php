<div class="section-title ml-5">
    <h4>{{strtoupper($newArrivals->name)}}</h4>
</div>
<div class="row mx-5 property__gallery slider-hero space">
    @foreach($newArrivals->products as $product)
        @include('inc.product')
    @endforeach
</div>