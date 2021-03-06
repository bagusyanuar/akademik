@extends('main.layouts')

@php
    $breadcrumb_item = [
        [
            'link' => '/dashboard',
            'title' => 'Dashboard'
        ],
        [
            'link' => '/',
            'title' => 'Absensi'
        ],
    ];
@endphp
@section('css')
    <style>
        .select2-selection {
            height: 40px !important;
            line-height: 40px !important;
        }

        .title-header-action {
            font-size: 14px;
            color: black;
        }

        .title-header-action:hover {
            text-decoration: underline;
        }


    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
@endsection
@section('content-title')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Halaman Absensi Kelas {{ $absen->kelas->nama }} Tanggal {{ $absen->tanggal }}</h4>
        <x-breadcrumb :item="$breadcrumb_item"></x-breadcrumb>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <x-card title="Daftar Absensi Kelas {{ $absen->kelas->nama }} Tanggal {{ $absen->tanggal }}" class="mt-3">
                <x-slot name="header_action">
                    <div class="d-flex">
                        <div class="d-flex align-items-center">
                            <span class="font-weight-bold mr-2">Periode : </span>
                            <a
                                class="title-header-action font-weight-bold text-black-50" id="label_periode"
                            >{{ $absen->periode->nama }}</a>
                        </div>
                        <span class="font-weight-bold mr-2 ml-2">|</span>
                        <div class="d-flex align-items-center">
                            <span class="font-weight-bold mr-2">Semester : </span>
                            <a class="title-header-action font-weight-bold text-black-50"
                               id="label_semester" data-semester="1">Semester{{ $absen->semester }}</a>
                        </div>
                    </div>
                </x-slot>
                <div class="text-right w-100 mb-3">
                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-absen-siswa"><i
                            class="fa fa-plus mr-2"></i><span>Buat Absensi</span></a>
                </div>
                <div>
                    <table id="my-table" class="table display w-100">
                        <thead class="w-100">
                        <tr>
                            <th width="10%" class="text-center">#</th>
                            <th width="30%">Nama Siswa</th>
                            <th width="10%">Absen</th>
                            <th width="30%">Keterangan</th>
                            <th width="20%" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody id="panel_nilai">
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>

    <div class="modal fade" id="modal-absen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Absen<span id="title-hari"
                                                                                   class="title-hari"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group w-100">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" id="tanggal" name="tanggal" class="form-control"
                                       value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary btn-save-absen">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-absen-siswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Absensi Siswa
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group w-100">
                                <label for="semester">Nama Siswa</label>
                                <x-form.select2 id="siswa" name="siswa">
                                    @foreach($siswa as $value)
                                        <option value="{{ $value->id }}">{{ $value->siswa->nama }}
                                            ({{$value->siswa->nis}})
                                        </option>
                                    @endforeach
                                </x-form.select2>
                            </div>
                            <div class="form-group w-100">
                                <label for="periode">Absen</label>
                                <select class="form-control" id="absen">
                                    <option value="masuk">Masuk</option>
                                    <option value="ijin">Ijin</option>
                                    <option value="alpha">Alpha</option>
                                </select>
                            </div>
                            <x-form.textarea id="keterangan" name="keterangan" label="Keterangan"></x-form.textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary btn-save-absen">Simpan</button>
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

        function elNilai(v, k) {
            let mapel = v['mata_pelajaran']['nama'];
            let nilai = 0;
            if (v['nilai'] !== null) {
                nilai = v['nilai']['nilai'];
            }
            return '<tr>' +
                '<td>' + (k + 1) + '</td>' +
                '<td>' + mapel + '</td>' +
                '<td>' + nilai + '</td>' +
                '<td><button class="btn btn-primary btn-sm btn-save-nilai" data-id="' + v['id'] + '" data-nilai="' + nilai + '"><i class="fa fa-edit"></i></button></td>' +
                '</tr>';
        }

        async function createAbsenSiswa() {
            try {
                let id = '{{ $absen->id }}';
                let siswa = $('#siswa').val();
                let keterangan = $('#keterangan').val();
                let absen = $('#absen').val();
                let response = await $.post('/absen/create-absen', {
                    '_token': '{{ csrf_token() }}',
                    id, siswa, keterangan, absen
                });
                if (response['status'] === 200) {
                    $('#modal-absen-siswa').modal('hide');
                    reload()
                } else {
                    sweetAlertMessage('Peringatan!', response['message'], 'warning')
                }
                console.log(response)
            } catch (e) {
                sweetAlertMessage('Peringatan!', 'Error', 'error')
                console.log(e)
            }
        }

        function reload() {
            table.ajax.reload();
        }

        function deleteAbsen(id) {
            confirmSweetAlert('Konfirmasi', 'Apakah Anda Yakin Menghapus Data?', async function () {
                try {
                    let data = {
                        '_token': '{{ csrf_token() }}',
                        id: id,
                    };
                    let response = await $.post('/absen/destroy/', data);
                    console.log(response)
                    if (response['status'] === 200) {
                        reload();
                    } else {
                        sweetAlertMessage('Peringatan!', response['msg'], 'warning')
                    }
                } catch (e) {
                    console.log(e)
                }
            });
        }

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let id = '{{ $absen->id }}';
            table = $('#my-table').DataTable({
                "scrollX": true,
                processing: true,
                ajax: {
                    type: 'GET',
                    url: '/absen/list-absen?id=' + id,
                },
                columnDefs: [
                    {
                        targets: 4,
                        className: 'dt-body-center'
                    }
                ],
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: 'siswa.siswa.nama'},
                    {data: 'nilai'},
                    {data: 'keterangan'},
                    {
                        data: null, render: function (data, type, row, meta) {
                            return '<a href="#" class="btn btn-primary btn-sm text-center btn-delete" data-id="' + data['id'] + '"><i class="fa fa-trash"></i></a>';
                        }
                    },
                ],
                paging: true,
            });

            table.on('draw', function () {
                $('.btn-delete').on('click', function (e) {
                    e.preventDefault();
                    let id = this.dataset.id;
                    deleteAbsen(id);
                })
            });


            $('.select2').select2({
                width: 'resolve'
            });


            $('.btn-save-absen').on('click', async function () {
                confirmSweetAlert('Konfirmasi', 'Yakin Ingin Melakukan Absen', function () {
                    createAbsenSiswa();
                })
            });

            $('.btn-change-periode').on('click', function () {
                let periode = $('#periode').val();
                let periodeText = $('#periode option:selected').text();
                $('#label_periode').data('periode', periode);
                $('#label_periode').html(periodeText);
                $('#modal-periode').modal('hide');
            });

            $('.btn-semester').on('click', function (e) {
                e.preventDefault();
                let semester = this.dataset.semester;
                console.log(semester);
                $('#label_semester').data('semester', semester);
                $('#label_semester').html(this.innerHTML);
            })
        });
    </script>
@endsection

