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
        <h4 class="mb-0">Halaman Absensi Kelas {{ $guru->kelas->nama }}</h4>
        <x-breadcrumb :item="$breadcrumb_item"></x-breadcrumb>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <x-card title="Form Absensi Kelas {{ $guru->kelas->nama }}" class="mt-3">
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
                <div class="text-right w-100 mb-3">
                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-absen"><i class="fa fa-plus mr-2"></i><span>Buat Absensi</span></a>
                </div>
                <div>
                    <table id="my-table" class="table display w-100">
                        <thead class="w-100">
                        <tr>
                            <th width="10%" class="text-center">#</th>
                            <th width="70%">Tanggal</th>
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
                    <input type="hidden" id="kelas" value="{{ $guru->kelas->id }}">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group w-100">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}">
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

        async function getNilai() {
            let el = $('#panel_nilai');
            el.empty();
            try {
                let siswa = $('#siswa').val();
                let periode = $('#label_periode').data('periode');
                let semester = $('#label_semester').data('semester');
                let response = await $.get('/penilaian/getNilai?siswa=' + siswa + '&periode=' + periode + '&semester=' + semester);
                console.log(response);
                let payload = response['payload'];
                $.each(payload, function (k, v) {
                    el.append(elNilai(v, k));
                });
                $('.btn-save-nilai').on('click', function () {
                    let id = this.dataset.id;
                    let nilai = this.dataset.nilai;
                    $('#idPelajaran').val(id);
                    $('#nilai').val(nilai);
                    $('#modal-nilai').modal('show');
                    console.log(id, nilai);
                })
            } catch (e) {
                console.log(e)
            }
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
                '<td>' + nilai + '</td>' +
                '<td><button class="btn btn-primary btn-sm btn-save-nilai" data-id="' + v['id'] + '" data-nilai="' + nilai + '"><i class="fa fa-edit"></i></button></td>' +
                '</tr>';
        }

        async function createAbsen() {
            try {
                let tanggal = $('#tanggal').val();
                let kelas = $('#kelas').val();
                let periode = $('#label_periode').data('periode');
                let semester = $('#label_semester').data('semester');
                let response = await $.post('/absen/create', {
                    '_token': '{{ csrf_token() }}',
                    tanggal, kelas, periode, semester
                });
                console.log(response);
                if (response['status'] === 200) {
                    $('#modal-absen').modal('hide');

                } else {
                    sweetAlertMessage('Peringatan!', response['message'], 'warning')
                }
                console.log(response)
            } catch (e) {
                sweetAlertMessage('Peringatan!', 'Error', 'error')
            }
        }

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            table = $('#my-table').DataTable({
                "scrollX": true,
                processing: true,
                ajax: {
                    type: 'GET',
                    url: '/absen/list?periode=1&kelas=6&semester=1',
                },
                columnDefs: [
                    {
                        targets: 2,
                        className: 'dt-body-center'
                    }
                ],
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: 'tanggal'},
                    {
                        data: null, render: function (data, type, row, meta) {
                            return '<a href="#" class="btn btn-primary btn-sm text-center">detail</a>';
                        }
                    },
                ],
                paging: true,
            });

            $('.select2').select2({
                width: 'resolve'
            });

            $('#siswa').on('change', function () {
                getNilai();
            });

            $('.btn-save-absen').on('click', async function () {
                confirmSweetAlert('Konfirmasi', 'Yakin Ingin Merubah Nilai?', function () {
                    createAbsen();
                })
            });

            $('.btn-change-periode').on('click', function () {
                let periode = $('#periode').val();
                let periodeText = $('#periode option:selected').text();
                $('#label_periode').data('periode', periode);
                $('#label_periode').html(periodeText);
                getNilai();
                $('#modal-periode').modal('hide');
            });

            $('.btn-semester').on('click', function (e) {
                e.preventDefault();
                let semester = this.dataset.semester;
                console.log(semester);
                $('#label_semester').data('semester', semester);
                $('#label_semester').html(this.innerHTML);
                getNilai();
            })
        });
    </script>
@endsection

