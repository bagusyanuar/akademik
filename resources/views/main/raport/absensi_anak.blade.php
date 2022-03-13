@extends('main.layouts')

@php
    $breadcrumb_item = [
        [
            'link' => '/dashboard',
            'title' => 'Dashboard'
        ],
        [
            'link' => '/',
            'title' => 'Raport Anak'
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
        <h4 class="mb-0">Halaman Absensi Anak Didik Bp/Ibu {{ $user->nama }}</h4>
        <x-breadcrumb :item="$breadcrumb_item"></x-breadcrumb>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <x-card title="Daftar Anak Didik" class="mt-3">
                <x-slot name="header_action">
                    <div class="d-flex">
                        <div class="d-flex align-items-center">
                            <span class="font-weight-bold mr-2">Periode : </span>
                            <a href="#" data-toggle="modal" data-target="#modal-periode"
                               class="title-header-action font-weight-bold text-black-50" id="label_periode"
                               data-periode="{{ $periode[0]->id }}">{{ $periode[0]->nama }}</a>
                        </div>
                        <span class="font-weight-bold mr-2 ml-2">|</span>
                        <div class="d-flex align-items-center">
                            <span class="font-weight-bold mr-2">Semester : </span>
                            <div class="dropdown">
                                <a href="#" class="title-header-action font-weight-bold text-black-50"
                                   data-toggle="dropdown" aria-expanded="false"
                                   id="label_semester" data-semester="1">Semester 1</a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item btn-semester" href="#" data-semester="1">Semester 1</a>
                                    <a class="dropdown-item btn-semester" href="#" data-semester="2">Semester 2</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </x-slot>
                <hr/>
                <div>
                    <table id="my-table" class="table display w-100">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Siswa</th>
                            <th scope="col">Kelas</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody id="panel_nilai">
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>

    <div class="modal fade" id="modal-nilai" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nilai Absensi<span id="title-hari"
                                                                                        class="title-hari"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Absen</th>
                                <th scope="col">Keterangan</th>
                            </tr>
                            </thead>
                            <tbody id="panel_detail_nilai">
                            </tbody>
                        </table>
                    </div>
                    <hr/>
                    <div class="font-weight-bold mb-2">Nilai Absensi Siswa</div>
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 font-weight-bold">Masuk</p>
                        <p class="mb-0 font-weight-bold" id="masuk">0</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 font-weight-bold">Ijin</p>
                        <p class="mb-0 font-weight-bold" id="ijin">0</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 font-weight-bold">Alpha</p>
                        <p class="mb-0 font-weight-bold" id="alpha">0</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 font-weight-bold">Tidak Absen</p>
                        <p class="mb-0 font-weight-bold" id="kosong">0</p>
                    </div>
                    <hr/>
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 font-weight-bold" style="font-size: 18px">Total Absen</p>
                        <p class="mb-0 font-weight-bold" id="total" style="font-size: 18px">0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-periode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Periode Pembelajaran
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group w-100">
                                <label for="periode">Periode</label>
                                <select class="form-control" id="periode">
                                    @foreach($periode as $v)
                                        <option value="{{ $v->id }}">{{ $v->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary btn-change-periode">Simpan</button>
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
        var ortu = '{{ $user->user->id }}';
        var periode = $('#label_periode').data('periode');
        var semester = $('#label_semester').data('semester');

        function reload() {
            console.log($('#label_periode').data('periode'));
            table.ajax.reload()
        }

        function elNilai(v, k) {
            let tanggal = v['tanggal'];
            let absen = 'Belum Di Absen';
            let keterangan = '-';
            if (v['nilaiabsen'] !== null) {
                absen = v['nilaiabsen']['nilai'];
                keterangan = v['nilaiabsen']['keterangan'];
            }
            return '<tr>' +
                '<td>' + (k + 1) + '</td>' +
                '<td>' + tanggal + '</td>' +
                '<td>' + absen + '</td>' +
                '<td>' + keterangan + '</td>' +
                '</tr>';
        }

        async function getDetail(id, kelas) {
            let el = $('#panel_detail_nilai');
            el.empty();
            try {
                let response = await $.get('/absensi-anak/list/detail?siswa=' + id + '&periode=' + periode + '&semester=' + semester + '&kelas=' + kelas);
                let payload = response['payload']['absensi'];
                let absen = response['payload']['absen'];
                if (payload.length > 0) {
                    $.each(payload, function (k, v) {
                        el.append(elNilai(v, k));
                    });
                } else {
                    el.append('<tr>' +
                        '<td colspan="3" class="font-weight-bold text-center">Belum Ada Absensi</td>' +
                        '</tr>');
                }
                $('#masuk').html(absen['masuk']);
                $('#ijin').html(absen['ijin']);
                $('#alpha').html(absen['alpha']);
                $('#kosong').html(absen['kosong']);
                $('#total').html(absen['total']);

                console.log(response);
                $('#modal-nilai').modal('show');
            } catch (e) {
                console.log(e);
            }
        }

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve'
            });

            table = $('#my-table').DataTable({
                "scrollX": true,
                processing: true,
                ajax: {
                    type: 'GET',
                    url: '/raport-anak/list',
                    'data': function (d) {
                        return $.extend(
                            {},
                            d,
                            {
                                'ortu': ortu,
                                'periode': periode,
                                'semester': semester,
                            }
                        );
                    }
                },
                columnDefs: [
                    {
                        targets: 2,
                        className: 'dt-body-center'
                    },
                    {
                        targets: 3,
                        className: 'dt-body-center'
                    },
                ],
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: 'nama'},
                    {data: 'kelas'},
                    {
                        data: null, render: function (data, type, row, meta) {
                            return '<a href="#" data-id="' + data['id'] + '" data-kelas="' + data['kelas_id'] + '" class="btn btn-primary btn-sm text-center btn-detail">detail</a>';
                        }
                    },
                ],
                paging: true,
            });

            $(document).on('click', '.btn-detail', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                let kelas = this.dataset.kelas;
                getDetail(id, kelas);
            });


            $('.btn-change-periode').on('click', function () {
                let vperiode = $('#periode').val();
                let periodeText = $('#periode option:selected').text();
                $('#label_periode').data('periode', vperiode);
                $('#label_periode').html(periodeText);
                periode = vperiode;
                reload();
                $('#modal-periode').modal('hide');
            });

            $('.btn-semester').on('click', function (e) {
                e.preventDefault();
                let vsemester = this.dataset.semester;
                console.log(semester);
                $('#label_semester').data('semester', vsemester);
                $('#label_semester').html(this.innerHTML);
                semester = vsemester;
                reload();
            })
        });
    </script>
@endsection

