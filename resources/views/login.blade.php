@extends('layouts/public', ['page'=>'login'])

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
                <div class="col-12">
                    <div class="contact__content">
                        <div class="contact__address">
                            <h5>Login Here</h5>
                            <p>Please enter your e-mail and password:</p>
                            
                            {!! Form::open(['url' => "login",'method' => 'post', 'class'=>'form-horizontal', ]) !!}
                                <div class="login-content">
                                    <input type="text" name="email" class="form-control my-3" placeholder="addyours@email.com"/>
                                    <input type="password" name="password" class="form-control my-3" placeholder="password" />
                                    <a href="/">Forgot password?</a>
                                    <input type="submit" class="form-control login-submit" value="Login" />
                                </div>
                            <p class="my-4" style="display:flex; justify-content:center">Don't have an account?<a href="{{url('register')}}" style="color:black; margin-left:1em;">Create one</a></p>

                            {!! Form::close() !!} 
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

@stop
