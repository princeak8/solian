<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Dashboard - {{ config('app.name', 'Laravel') }}</title>
    
    <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/vendors/chartjs/Chart.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/vendors/perfect-scrollbar/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/vendors/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/template.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/dataTableBootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/fontawesome.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- <link href="vendor/.css" rel="stylesheet" type="text/css"> -->

    <link rel="stylesheet" href="{{asset('assets/admin/css/sb-admin-2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/app.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.svg')}}" type="image/x-icon">
    
    <script src="{{asset('assets/admin/js/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/dataTableBootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/moment.js')}}"></script>
    <script> 
    document.addEventListener("DOMContentLoaded", function(event) { 
        moment.locale("{{app()->getLocale()}}")
    });
    </script>
    @yield('styles')

</head>