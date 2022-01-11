@extends('main.layouts')

@php
    $breadcrumb_item = [
        [
            'link' => '/dashboard',
            'title' => 'Dashboard'
        ],
        [
            'link' => '/',
            'title' => 'Siswa'
        ],
    ];
@endphp
@section('css')
    <link rel="stylesheet" href="{{ asset('/adminlte/plugins/datatables/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content-title')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Halaman Data Siswa</h4>
        <x-breadcrumb :item="$breadcrumb_item"></x-breadcrumb>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <x-card title="Data Siswa" class="mt-3">
                <x-slot name="header_action">
                    <a href="/siswa/tambah" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>Tambah</a>
                </x-slot>
                <table id="my-table" class="table display">
                    <thead>
                    <tr>
                        <th width="8%" class="text-center">#</th>
                        <th width="10%">NIS</th>
                        <th width="20%">Nama Lengkap</th>
{{--                        <th width="10%">Kelas</th>--}}
                        <th width="15%">Orang Tua</th>
                        <th width="15%">Tanggal Lahir</th>
                        <th width="20%">Alamat</th>
                        <th width="20%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $siswa)
                        <tr>
                            <td class="text-center">{{ $loop->index +1 }}</td>
                            <td>{{ $siswa->nis }}</td>
                            <td>{{ $siswa->nama }}</td>
{{--                            <td>{{ $siswa->kelas === null ? '-' : $siswa->kelas->nama }}</td>--}}
                            <td>{{ $siswa->orangTua === null ? '-' : $siswa->orangTua->nama }}</td>
                            <td>{{ $siswa->tgl_lahir }}</td>
                            <td>{{ $siswa->alamat }}</td>
                            <td>
                                <a href="/siswa/edit/{{ $siswa->id }}" class="btn btn-warning"><i
                                        class="fa fa-edit"></i></a>
                                <button type="button" class="btn btn-danger btn-delete" data-id="{{$siswa->id}}"><i
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
                        let response = await $.post('/siswa/destroy/' + id, data);
                        if (response['code'] === 200) {
                            window.location.href = '/siswa';
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

