@extends('main.layouts')

@php
    $breadcrumb_item = [
        [
            'link' => '/dashboard',
            'title' => 'Dashboard'
        ],
        [
            'link' => '/',
            'title' => 'Admin'
        ],
    ];
@endphp
@section('css')
    <link rel="stylesheet" href="{{ asset('/adminlte/plugins/datatables/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content-title')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Halaman Admin</h4>
        <x-breadcrumb :item="$breadcrumb_item"></x-breadcrumb>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <x-card title="Data guru" class="mt-3">
                <x-slot name="header_action">
                    <a href="/admin/tambah" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>Tambah</a>
                </x-slot>
                <table id="my-table" class="table display">
                    <thead>
                    <tr>
                        <th width="8%" class="text-center">#</th>
                        <th width="20%">Username</th>
                        <th width="60%">Nama Lengkap</th>
                        <th width="12%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $admin)
                        <tr>
                            <td class="text-center">{{ $loop->index +1 }}</td>
                            <td>{{ $admin->user->username }}</td>
                            <td>{{ $admin->nama }}</td>
                            <td>
                                <a href="/admin/edit/{{ $admin->id }}" class="btn btn-warning"><i
                                        class="fa fa-edit"></i></a>
                                <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </x-card>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('/adminlte/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#my-table').DataTable();
        });
    </script>
@endsection

