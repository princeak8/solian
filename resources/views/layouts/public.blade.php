@include('layouts.public.header')           

<body>
@include('layouts.public.sidenav') 

@yield('css')

</header>
   
    <!-- ========================================================================================== -->
    <!-- ======================== B O D Y === B E G I N S ===================================== -->
    <!-- ========================================================================================== -->

    @yield('content')

   
    <!-- ================= Top Fading Images  begins ==================== -->

<!-- ============== BLOGS ENDS ============================ -->


<!-- Footer Section Begin -->

@include('layouts.public.footer')   

@yield('js')

</body>

</html>