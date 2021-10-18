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
<x-navbar class="elevation-1">
    <x-navbar.left-navbar :isPushMenu="true">
    </x-navbar.left-navbar>
    <x-navbar.right-navbar>
        <x-navbar.item class="d-sm-inline-block"><a href="#" class="nav-link navbar-link-item">Logout</a></x-navbar.item>
    </x-navbar.right-navbar>

</x-navbar>
<x-sidebar class="sidebar-dark-primary elevation-1">
    <x-slot name="brand">
        <x-sidebar.brand></x-sidebar.brand>
    </x-slot>
    <x-slot name="menu">
        <x-sidebar.menu>
            <x-sidebar.item title="Dashboard" link="/" icon="fa fa-tachometer" />
            <x-sidebar.header-menu title="Master"/>
            <x-sidebar.tree-menu title="Pengguna" icon="fa fa-users">
                <x-sidebar.item title="Admin" link="/admin" />
                <x-sidebar.item title="Guru" link="/guru" />
                <x-sidebar.item title="Orang Tua" link="/orang-tua" />
                <x-sidebar.item title="Siswa" link="/siswa" />
            </x-sidebar.tree-menu>
            <x-sidebar.tree-menu title="Akademik" icon="fa fa-hdd-o">
                <x-sidebar.item title="Periode" link="/periode" />
                <x-sidebar.item title="Kelas" link="/kelas" />
                <x-sidebar.item title="Mata Pelajaran" link="/mata-pelajaran" />
            </x-sidebar.tree-menu>
            <x-sidebar.header-menu title="Transaction"/>
            <x-sidebar.item title="Menu Item 1" link="/" />
        </x-sidebar.menu>
    </x-slot>
</x-sidebar>
<div class="content-wrapper p-3">
        @yield('content-title')
        @yield('content')
</div>
</body>
<script src="{{ asset('/jQuery/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset ('/adminlte/js/adminlte.js') }}"></script>
@yield('js')
</html>
