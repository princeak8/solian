<style type="text/css">
    .head-bg {
    	background: #87CEEB;
        padding: 0 2em;
        margin: 0.5em 0;
        border-radius: 5px;
    }
    .head-bg ul {
        display: flex;
        justify-content: space-around;
    }
    .head-bg ul li {
        list-style-type: none;
        display: flex;
        align-items: center;
        justify-content: space-around;
    }

    .photoHeader {
        color: #0066bd;
        text-decoration: none;
        font-weight: 600;
        padding: 1em;
    }
    .photoHeader:hover {
        background: white;
        color: #0066bd;
        border-radius: 15px;
        text-decoration: none;
    }
   
    .head-bg .active {
        background: white;
        color: #0066bd !important;
        border-radius: 15px;
        margin: 0.5em 0;
    }

</style>

<div>
    <div class="head-bg">
        <ul>
            <li class="{{ (request()->is('admin/photos')) ? 'active' : '' }}">
                <a class="photoHeader" href="{{url('admin/photos')}}"><span>Unattached Photos</span></a>
            </li>
            <li class="{{ (request()->is('admin/product_photos')) ? 'active' : '' }}">
                <a class="photoHeader"  href="{{url('admin/product_photos')}}"><span>Product Photos</span></a>
            </li>
            <li class="{{ (request()->is('admin/collection_photos')) ? 'active' : '' }}">
                <a class="photoHeader"  href="{{url('admin/collection_photos')}}"><span>Collection Photos</span></a>
            </li>
            <li class="{{ (request()->is('admin/slide_photos')) ? 'active' : '' }}">
                <a class="photoHeader"  href="{{url('admin/slide_photos')}}"><span>Slides</span></a>
            </li>
        </ul>
    </div>
</div>