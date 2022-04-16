<style type="text/css">
    nav {
    	background: #0066bd;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 0 2em;
        margin: 0.5em 0;
        border-radius: 15px;
        box-shadow: 0 2px 3px 0 rgba(0,0,0.1);
        height: 50px;
        width: 100%;
    }
   
    nav .photo-title {
        color: white;
        text-decoration: none;
        line-height: 50px;
        font-weight: 600;
       
    }
   
    .activ, .photo-title:hover {
        display: flex;
        align-items: center;
        height: 40px;
        top: 0;
        text-decoration: none;
        font-weight: 600;
        background: white;
        color: #0066bd;
        border-radius: 15px;
        margin-top: 5px;
        padding: 0 1em;
        box-shadow: 0 2px 3px 0 rgba(0,0,0.1);
        transition: all .9s ease 0s;
    }
    
</style>

<div>
    <nav>
        <a class="photo-title" href="{{url('admin/photos')}}"><span>Unattached Photos</span></a>
        <a class="photo-title" href="{{url('admin/product_photos')}}"><span>Product Photos</span></a>
        <a class="photo-title" href="{{url('admin/collection_photos')}}"><span>Collection Photos</span></a>
        <a class="photo-title" href="{{url('admin/slide_photos')}}"><span>Slides</span></a>
    </nav>
</div>

@section('js')
    <script type="application/javascript">
        //  $(document).ready(function() {
        //     $('.photoHeader').click(function(event){
        //         event.preventDefault()
        //         console.log('check');
        //     $('a').removeClass("activ");
        //     $(this).addClass("activ");
        //     });    
        // });
        const currentLocation = location.href;
        const menuItem = document.querySelectorAll('a');
        const menuLength = menuItem.length
        for(let i = 0; i<menuLength; i++){
            if(menuItem[i].href === currentLocation){
                menuItem[i].className = "activ"
            };
        };
    </script>

@stop