@include('layouts.header')
<body>
    <div id="app">
        <div id="sidebar" class='active'>
            @include('layouts.sidebar')
        </div>
        <div id="main">
            @include('layouts.nav');            
            <div class="main-content container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h3>{{trans($root)}}</h3>
                            <p class="text-subtitle text-muted">{{trans($description)}}</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <nav aria-label="breadcrumb" class='breadcrumb-header text-right'>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">{{trans($root)}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{trans($title)}}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                @if(session()->has('errors') || session()->has('error') || session()->has('message'))
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class ="card-body">
                                    @if(session()->has('error'))
                                        <div class="alert alert-danger">
                                            {{ session()->get('error') }}
                                        </div>
                                    @endif
                                    @if(session()->has('errors'))
                                        <div class="alert alert-danger">
                                        <?php $errors =  session()->get('errors');?>
                                        @foreach ($errors->all()  as $error)
                                            {{ $error }} <br/>
                                        @endforeach
                                        </div>                                        
                                    @endif
                                    @if(session()->has('message'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @yield('content')
            </div>
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-left">
                        {{--  <p>2020 &copy; </p>  --}}
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script>
    var LANGUAGE = {
        "decimal":        "",
        "emptyTable":     "{{__('No data available in table')}}",
        "info":           "{{__('Showing')}} _START_ {{__('to')}} _END_ {{__('of')}} _TOTAL_ {{__('entries')}}",
        "infoEmpty":      "{{__('Showing')}} 0 {{__('to')}} 0 {{__('of')}} 0 {{__('entries')}}",
        "infoFiltered":   "({{__('filtered from')}} _MAX_ {{__('total entries')}})",
        "infoPostFix":    "",
        "thousands":      ",",
        "lengthMenu":     "{{__('Show')}} _MENU_ {{__('entries')}}",
        "loadingRecords": "{{__('Loading...')}}",
        "processing":     "{{__('Processing...')}}",
        "search":         "{{__('Search')}}:",
        "zeroRecords":    "{{__('No matching records found')}}",
        "paginate": {
            "first":      "{{__('First')}}",
            "last":       "{{__('Last')}}",
            "next":       "{{__('Next')}}",
            "previous":   "{{__('Previous')}}"
        },
        "aria": {
            "sortAscending":  ": {{__('activate to sort column ascending')}}",
            "sortDescending": ": {{__('activate to sort column descending')}}"
        }
    }
    </script>
    <script src="{{asset('assets/js/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/bundle.js')}}"></script>
    <script src="{{asset('assets/js/template.js')}}"></script>
    <script src="{{asset('assets/js/vue.js')}}"></script>
    <script src="{{asset('assets/js/axios.min.js')}}"></script>
    @yield('js')
</body>
</html>
@include('layouts.footer')
