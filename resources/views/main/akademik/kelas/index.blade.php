@extends('main.layouts')

@php
    $breadcrumb_item = [
        [
            'link' => '/dashboard',
            'title' => 'Dashboard'
        ],
        [
            'link' => '/',
            'title' => 'Kelas'
        ],
    ];
@endphp
@section('css')
{{--    <link rel="stylesheet" href="{{ asset('/adminlte/plugins/datatables/dataTables.bootstrap4.min.css') }}">--}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">

@endsection
@section('content-title')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Halaman Kelas</h4>
        <x-breadcrumb :item="$breadcrumb_item"></x-breadcrumb>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <x-card title="Data Kelas" class="mt-3">
                <x-slot name="header_action">
                    <a href="/kelas/tambah" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>Tambah</a>
                </x-slot>
                <table id="my-table" class="table display">
                    <thead>
                    <tr>
                        <th width="10%" class="text-center">#</th>
                        <th width="70%">Nama</th>
                        <th width="20%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $kelas)
                        <tr>
                            <td class="text-center">{{ $loop->index +1 }}</td>
                            <td>{{ $kelas->nama }}</td>
                            <td class="text-center">
                                <a href="/kelas/edit/{{ $kelas->id }}" class="btn btn-warning"><i
                                        class="fa fa-edit"></i></a>
                                <button type="button" class="btn btn-danger btn-delete" data-id="{{$kelas->id}}"><i
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
{{--    <script src="{{ asset('/adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>--}}
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
{{--    <script src="{{ asset('/adminlte/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>--}}

    <script src="{{ asset('/helper/helper.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#my-table').DataTable({
                paging: true,
            });

            $('.btn-delete').on('click', function () {
                let id = this.dataset.id;
                confirmSweetAlert('Konfirmasi', 'Apakah Anda Yakin Menghapus Data?', async function () {
                    try {
                        let data = {
                            '_token': '{{ csrf_token() }}'
                        };
                        let response = await $.post('/kelas/destroy/' + id, data);
                        if (response['code'] === 200) {
                            window.location.href = '/kelas';
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

