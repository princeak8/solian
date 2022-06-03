<div class="section-title ml-3">
    <h4>{{strtoupper($newArrivals->name)}}</h4>
</div>
<div class="row mx-3 property__gallery slider-hero space">
    @foreach($newArrivals->products as $product)
        @include('inc.product')
    @endforeach
</div>