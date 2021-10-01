<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('title', 'Dashboard Admin')</title>
    <link rel="stylesheet" href="{{asset ('/adminlte/plugins/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('/adminlte/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{ asset('style/main.css') }}">
    <link rel="stylesheet" href="{{ asset('/sweetalert/sweetalert2.css') }}">
    <script src="{{ asset('/sweetalert/sweetalert2.js') }}"></script>
    @yield('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>
</nav>
<aside class="main-sidebar sidebar-dark-primary elevation-4 my-sidebar">
    <div class="sidebar my-content-sidebar">
        <div class="brand-link my-text-light d-flex justify-content-center align-items-center mb-3"
             style="border-bottom: 1px solid white;">
            SISTEM AKADEMIK MTA
        </div>
        <div class="my-sidebar-menu">
            <ul class="nav nav-sidebar nav-pills flex-column">
                <li class="nav-item has-treeview" data-view="treeview" role="menu" data-accordion="false">
                    <a href="#" class="nav-link tree-item">
                        <i class="nav-icon fa fa-hdd-o" aria-hidden="true"></i>
                        <p>
                            Master
                            <i class="right fa fa-angle-down"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</aside>
<div class="content-wrapper my-content-wrapper">
    <div class="my-content">
        <div class="my-content-title-wrapper">
            <div>@yield('content-title')</div>
        </div>
        @yield('breadcrumb')
        @yield('content')
    </div>
</div>
</body>
<script src="{{ asset('/jQuery/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset ('/adminlte/js/adminlte.js') }}"></script>
</html>
