@extends('main.layouts')

@php
    $breadcrumb_item = [
        [
            'link' => '/dashboard',
            'title' => 'Dashboard'
        ],
        [
            'link' => '/',
            'title' => 'Data Kelas Siswa'
        ],
    ];
@endphp
@section('css')
    <style>
        .select2-selection {
            height: 40px !important;
            line-height: 40px !important;
        }

        .title-hari {
            text-transform: capitalize;
        }

    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
@endsection
@section('content-title')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Halaman Data Kelas Siswa</h4>
        <x-breadcrumb :item="$breadcrumb_item"></x-breadcrumb>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <x-card title="Data Kelas Siswa" class="mt-3">
                <x-slot name="header_action">
                    <a href="#" class="btn btn-primary" id="modalTambah"><i class="fa fa-plus mr-1"></i>Tambah</a>
                </x-slot>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="periode">Periode Belajar</label>
                            <x-form.select2 id="periode" name="periode">
                                @foreach($periode as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                @endforeach
                            </x-form.select2>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="kelas">Kelas</label>
                            <x-form.select2 id="kelas" name="kelas">
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                @endforeach
                            </x-form.select2>
                        </div>
                    </div>
                </div>
                <hr/>
                <div>
                    <table id="my-table" class="table display w-100">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Siswa</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Aksi</th>
                        </tr>
                        </thead>
                        <tbody id="panel_nilai">
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>

    <div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Daftar Siswa <span id="title-hari"
                                                                                            class="title-hari"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="my-table-2" class="table display w-100">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIS</th>
                            <th scope="col">Nama Siswa</th>
                            <th scope="col">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($siswa as $v)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $v->nis }}</td>
                                <td>{{ $v->nama }}</td>
                                <td><a href="#" class="btn btn-primary btn-sm btn-pilih"
                                       data-id="{{ $v->id }}">Pilih</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('/helper/helper.js') }}"></script>
    <script>
        let table;
        var kelas = $('#kelas').val();
        var periode = $('#periode').val();

        function reload() {
            table.ajax.reload()
        }

        async function registerSiswa(siswa) {
            try {
                let response = await $.post('/kelas-siswa/register', {
                    _token: '{{ csrf_token() }}',
                    kelas: $('#kelas').val(),
                    periode: $('#periode').val(),
                    siswa: siswa
                });
                console.log(response);
                if (response['status'] === 200) {
                    reload();
                    $('#modal-tambah').modal('hide');
                } else {
                    alert(response['message']);
                }
            } catch (e) {
                alert('Terjadi Kesalahan')
            }
        }

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve'
            });

            $('#modalTambah').on('click', function (e) {
                e.preventDefault();
                $('#modal-tambah').modal('show');
            });

            $('.btn-pilih').on('click', function (e) {
                e.preventDefault();
                registerSiswa(this.dataset.id)
            });

            $('#my-table-2').DataTable();

            table = $('#my-table').DataTable({
                "scrollX": true,
                processing: true,
                ajax: {
                    type: 'GET',
                    url: '/kelas-siswa/list',
                    'data': function (d) {
                        return $.extend(
                            {},
                            d,
                            {
                                'kelas': $('#kelas').val(),
                                'periode': $('#periode').val(),
                            }
                        );
                    }
                },
                columnDefs: [
                    {
                        targets: 3,
                        className: 'dt-body-center'
                    }
                ],
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: 'siswa.nama'},
                    {data: 'siswa.alamat'},
                    {
                        data: null, render: function (data, type, row, meta) {
                            return '<a href="#" data-id="' + data['id'] + '" class="btn btn-primary btn-sm text-center btn-detail">detail</a>';
                        }
                    },
                ],
                paging: true,
            });

            $('#kelas').on('change', function () {
                console.log(kelas)
                reload();
            });
            $('#periode').on('change', function () {
                console.log($('#periode').val())
                reload();
            });
        });
    </script>
@endsection

