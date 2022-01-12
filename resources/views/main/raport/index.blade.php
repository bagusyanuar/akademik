@extends('main.layouts')

@php
    $breadcrumb_item = [
        [
            'link' => '/dashboard',
            'title' => 'Dashboard'
        ],
        [
            'link' => '/',
            'title' => 'Raport'
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
        <h4 class="mb-0">Halaman Raport Kelas {{ $guru->kelas->nama }}</h4>
        <x-breadcrumb :item="$breadcrumb_item"></x-breadcrumb>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <x-card title="Form Penilaian Kelas {{ $guru->kelas->nama }}" class="mt-3">
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
                                <a href="#" class="title-header-action font-weight-bold text-black-50" data-toggle="dropdown" aria-expanded="false"
                                   id="label_semester" data-semester="1">Semester 1</a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item btn-semester" href="#" data-semester="1">Semester 1</a>
                                    <a class="dropdown-item btn-semester" href="#" data-semester="2">Semester 2</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </x-slot>

{{--                <div class="form-group w-100">--}}
{{--                    <label for="semester">Nama Siswa</label>--}}
{{--                    <x-form.select2 id="siswa" name="siswa">--}}
{{--                        @foreach($siswa as $value)--}}
{{--                            <option value="{{ $value->id }}">{{ $value->nama }}</option>--}}
{{--                        @endforeach--}}
{{--                    </x-form.select2>--}}
{{--                </div>--}}
                <hr/>
                <div>
                    <table id="my-table" class="table display w-100">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Siswa</th>
                            <th scope="col" class="text-center">Rata - Rata</th>
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
                    <h5 class="modal-title" id="exampleModalLabel">Nilai Pelajaran<span id="title-hari"
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
                                <th scope="col">Mata Pelajaran</th>
                                <th scope="col" class="text-right">Nilai</th>
                            </tr>
                            </thead>
                            <tbody id="panel_detail_nilai">
                            </tbody>
                        </table>
                    </div>
                    <hr/>
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 font-weight-bold">Nilai Rata - Rata</p>
                        <p class="mb-0 font-weight-bold" id="nilai">0</p>
                    </div>
                    <hr/>
                    <div class="font-weight-bold ">Nilai Absensi Siswa</div>
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 font-weight-bold">Masuk</p>
                        <p class="mb-0 font-weight-bold" id="masuk">0</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 font-weight-bold">Ijin</p>
                        <p class="mb-o font-weight-bold" id="ijin">0</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 font-weight-bold">Alpha</p>
                        <p class="mb-o font-weight-bold" id="alpha">0</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 font-weight-bold">Tidak Absen</p>
                        <p class="mb-o font-weight-bold" id="Kosong">0</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 font-weight-bold">Total Absen</p>
                        <p class="mb-o font-weight-bold" id="total">0</p>
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
        var kelas = '{{ $guru->kelas->id }}';
        var periode = $('#label_periode').data('periode');
        var semester = $('#label_semester').data('semester');

        function reload() {
            console.log($('#label_periode').data('periode'));
            table.ajax.reload()
        }

        function elNilai(v, k) {
            let mapel = v['mata_pelajaran']['nama'];
            let nilai = 0;
            if (v['nilai'] !== null) {
                nilai = v['nilai']['nilai'];
            }
            return '<tr>' +
                '<td>' + (k + 1) + '</td>' +
                '<td>' + mapel + '</td>' +
                '<td class="text-right">' + nilai + '</td>' +
                '</tr>';
        }
        async function getDetail(id) {
            let el = $('#panel_detail_nilai');
            el.empty();
            try {
                let response = await $.get('/raport/list/detail?siswa='+id+'&periode='+periode+'&semester='+semester+'&kelas='+kelas);
                let payload = response['payload']['pelajaran'];
                let absen = response['payload']['absen'];

                $.each(payload, function (k, v) {
                    el.append(elNilai(v, k));
                });
                let total_nilai = payload.reduce((n, {nilai}) => n + (nilai === null ? 0 : nilai.nilai), 0);
                $('#nilai').html(Math.round((total_nilai / payload.length), 0));
                $('#masuk').html(absen['masuk']);
                $('#ijin').html(absen['ijin']);
                $('#alpha').html(absen['alpha']);
                $('#kosong').html(absen['kosong']);
                $('#total').html(absen['total']);

                console.log(response);
                console.log(total_nilai);
                $('#modal-nilai').modal('show');
            }catch(e) {
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
                    url: '/raport/list',
                    'data': function (d) {
                        return $.extend(
                            {},
                            d,
                            {
                                'kelas': kelas,
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
                    }
                ],
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: 'nama'},
                    {data: 'rata_rata'},
                    {
                        data: null, render: function (data, type, row, meta) {
                            return '<a href="#" data-id="'+data['id']+'" class="btn btn-primary btn-sm text-center btn-detail">detail</a>';
                        }
                    },
                ],
                paging: true,
            });

            $(document).on('click', '.btn-detail' ,function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                getDetail(id);
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

