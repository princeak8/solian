<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ashion Template">
    <meta name="keywords" content="Ashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Solian | Home</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome-free-5.14.0-web/css/all.min.css')}}">


    <!-- Css Styles -->
      <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap-4.5.0-dist/css/bootstrap.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awesome.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('assets/css/elegant-icons.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jquery-ui.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('assets/css/magnific-popup.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('assets/css/owl.carousel.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('assets/css/slicknav.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('assets/css/mymain.css')}}">
      
      <!-- Slick Styles -->
      <link rel="stylesheet" type="text/css" href="{{asset('assets/slick-1.8.1/slick/slick.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('assets/slick-1.8.1/slick/slick-theme.css')}}">
      <link rel="stylesheet" href="{{asset('assets/slick-1.8.1/slick/fonts/slick.svg')}}">

  @yield('css')

</head>

