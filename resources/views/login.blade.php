@extends('layouts/public')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                        <span>Login</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="contact__content">
                        <div class="contact__address">
                            <h5>Login Here</h5>
                            
                            {!! Form::open(['url' => "login",'method' => 'post', 'class'=>'form-horizontal', ]) !!}
                                <div>
                                    <input type="text" name="email" class="form-control" />
                                    <input type="password" name="password" class="form-control" />

                                    <input type="submit" class="form-control" value="Login" />
                                </div>
                            {!! Form::close() !!} 
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

@stop
