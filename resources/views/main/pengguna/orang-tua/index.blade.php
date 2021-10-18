@extends('main.layouts')

@php
    $breadcrumb_item = [
        [
            'link' => '/dashboard',
            'title' => 'Dashboard'
        ],
        [
            'link' => '/',
            'title' => 'Orang Tua Siswa'
        ],
    ];
@endphp
@section('css')
    <link rel="stylesheet" href="{{ asset('/adminlte/plugins/datatables/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content-title')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Halaman Data Orang Tua Siswa</h4>
        <x-breadcrumb :item="$breadcrumb_item"></x-breadcrumb>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <x-card title="Data Orang Tua Siswa" class="mt-3">
                <x-slot name="header_action">
                    <a href="/orang-tua/tambah" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>Tambah</a>
                </x-slot>
                <table id="my-table" class="table display">
                    <thead>
                    <tr>
                        <th width="8%" class="text-center">#</th>
                        <th width="15%">Username</th>
                        <th width="20%">Nama Lengkap</th>
                        <th width="15%">No. Hp</th>
                        <th width="30%">Alamat</th>
                        <th width="12%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $orang_tua)
                        <tr>
                            <td class="text-center">{{ $loop->index +1 }}</td>
                            <td>{{ $orang_tua->user->username }}</td>
                            <td>{{ $orang_tua->nama }}</td>
                            <td>{{ $orang_tua->no_hp }}</td>
                            <td>{{ $orang_tua->alamat }}</td>
                            <td>
                                <a href="/orang-tua/edit/{{ $orang_tua->id }}" class="btn btn-warning"><i
                                        class="fa fa-edit"></i></a>
                                <button type="button" class="btn btn-danger btn-delete" data-id="{{$orang_tua->user->id}}"><i
                                        class="fa fa-trash"></i></button>
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
    <script src="{{ asset('/helper/helper.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#my-table').DataTable();

            $('.btn-delete').on('click', function () {
                let id = this.dataset.id;
                confirmSweetAlert('Konfirmasi', 'Apakah Anda Yakin Menghapus Data?', async function () {
                    try {
                        let data = {
                            '_token': '{{ csrf_token() }}'
                        };
                        let response = await $.post('/orang-tua/destroy/' + id, data);
                        if (response['code'] === 200) {
                            window.location.href = '/orang-tua';
                        } else {
                            sweetAlertMessage('Peringatan!', response['msg'], 'warning')
                        }
                    } catch (e) {
                        console.log(e)
                    }
                })
            })
        });
    </script>
@endsection

