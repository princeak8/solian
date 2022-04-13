<style type="text/css">
    .head-bg {
    	background: #0066bd;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 0 2em;
        margin: 0.5em 0;
        border-radius: 5px;
    }
   
    .photoHeader {
        color: white;
        text-decoration: none;
        padding: 1em;
    }
    .photoHeader:hover {
        background: white;
        color: #0066bd;
        /* border: 0.5px solid gray; */
        border-radius: 15px;
        margin: 0.5em 0;
        text-decoration: none;

    }
    .activ {
        background: white;
        color: #0066bd;
        /* border: 0.5px solid gray; */
        border-radius: 15px;
        margin: 0.5em 0;
    }

</style>

<div>
    <div class="head-bg">
            <a class="activ photoHeader" href="{{url('photos')}}"><span>Unattached Photos</span></a>
            <a class="photoHeader" href="{{url('admin/product_photos')}}"><span>Product Photos</span></a>
            <a class="photoHeader"  href="{{url('admin/collection_photos')}}"><span>Collection Photos</span></a>
            <a class="photoHeader"  href="{{url('admin/slide_photos')}}"><span>Slides</span></a>
    </div>
</div>