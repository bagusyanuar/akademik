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
<x-navbar class="dark-navbar">
    <x-navbar.left-navbar :isPushMenu="true">
        <x-navbar.item class="d-sm-inline-block"><a href="#" class="nav-link">Contact</a></x-navbar.item>
    </x-navbar.left-navbar>
    <x-navbar.right-navbar>
        <x-navbar.item class="d-sm-inline-block"><a href="#" class="nav-link">Logout</a></x-navbar.item>
    </x-navbar.right-navbar>

</x-navbar>
@php
    $menuMaster = [['link' => '/', 'title' => 'User'],
        ['link' => '/', 'title' => 'Admin'],
        ['link' => '/', 'title' => 'Siswa'],];

@endphp
<x-sidebar class="sidebar-dark-primary elevation-1">
    <x-slot name="brand">
        <x-sidebar.brand></x-sidebar.brand>
    </x-slot>
    <x-slot name="menu">
        <x-sidebar.menu>
            <x-sidebar.tree-menu title="Master" icon="fa fa-hdd-o" :children="$menuMaster"/>
            <x-sidebar.header-menu title="Transaction"/>
            <x-sidebar.item title="Menu Item 1" link="/" />
        </x-sidebar.menu>
    </x-slot>
</x-sidebar>
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
