@extends('main.layouts')

@php
    $breadcrumb_item = [
        [
            'link' => '/dashboard',
            'title' => 'Dashboard'
        ],
        [
            'link' => '/',
            'title' => 'Pelajaran Kelas'
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
@endsection
@section('content-title')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Halaman Pelajaran Kelas</h4>
        <x-breadcrumb :item="$breadcrumb_item"></x-breadcrumb>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <x-card title="Data Pelajaran Kelas" class="mt-3">
                <x-slot name="header_action">
                    <a href="#" class="btn btn-primary btn-add-subject"><i class="fa fa-plus mr-1"></i>Tambah</a>
                </x-slot>

                <div class="row">
                    <div class="col-4">
                        <div class="form-group w-100">
                            <label for="periode">Periode Belajar</label>
                            <x-form.select2 id="periode" name="periode">
                                @foreach($periode as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                @endforeach
                            </x-form.select2>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group w-100">
                            <label for="kelas">Kelas</label>
                            <x-form.select2 id="kelas" name="kelas">
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                @endforeach
                            </x-form.select2>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group w-100">
                            <label for="semester">Semester</label>
                            <x-form.select2 id="semester" name="semester">
                                <option value="1">Semester 1</option>
                                <option value="2">Semester 2</option>
                            </x-form.select2>
                        </div>
                    </div>
                </div>
                <hr/>
                <div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Mata Pelajaran</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="panel-pelajaran">
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>

    <div class="modal fade" id="modal-schedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Jadwal Hari <span id="title-hari"
                                                                                            class="title-hari"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="hari" value="">
                    <div class="form-group w-100">
                        <label for="mata_pelajaran">Mata Pelajaran</label>
                        <x-form.select2 id="mata_pelajaran" name="mata_pelajaran">
                            @foreach($mata_pelajaran as $pelajaran)
                                <option value="{{ $pelajaran->id }}">{{ $pelajaran->nama }}</option>
                            @endforeach
                        </x-form.select2>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary btn-save-subject">Tambah</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/helper/helper.js') }}"></script>
    <script>
        function elTable(list) {
            return '<table class="table">' +
                '<thead>' +
                '<tr>' +
                '<th scope="col">#</th>' +
                '<th scope="col">Mata Pelajaran</th>' +
                '<th scope="col">Waktu</th>' +
                '<th scope="col">Aksi</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' + list +
                '</tbody>' +
                '</table>';
        }

        function singleList(index, value) {
            let {id} = value;
            return '<tr>' +
                '<th scope="row">' + index + '</th>' +
                '<td>' + value['mata_pelajaran']['nama'] + '</td>' +
                '<td><button type="button" class="btn btn-sm btn-danger btn-delete-jadwal" data-id="' + id + '"><i class="fa fa-trash"></i></button></td>' +
                '</tr>';
        }

        function elEmpty() {
            return '<div class="d-block text-center">' +
                '<span class="font-weight-bold text-center d-block mb-1">Pelajaran Belum Tersedia</span>' +
                '</div>';
        }

        async function getList() {
            try {
                let periode = $('#periode').val();
                let kelas = $('#kelas').val();
                let semester = $('#semester').val();
                let response = await $.get('/pelajaran-kelas/list?periode=' + periode + '&kelas=' + kelas + '&semester=' + semester);
                let data = response['payload']['data'];
                let element = $('#panel-pelajaran');
                element.empty();
                if(data.length > 0 ) {
                    $.each(data, function (k, v) {
                        element.append(singleList((k + 1), v));
                    })
                }else {
                    element.append(elEmpty());
                }
                console.log(response)
            } catch (e) {
                console.log(e)
            }
        }

        async function addJadwal() {
            try {
                let data = {
                    _token: '{{csrf_token()}}',
                    periode: $('#periode').val(),
                    hari: $('#hari').val(),
                    kelas: $('#kelas').val(),
                    mata_pelajaran: $('#mata_pelajaran').val(),
                    mulai: $('#mulai').val(),
                    selesai: $('#selesai').val(),
                    semester: $('#semester').val(),
                };
                let response = await $.post('/jadwal/store', data);
                if (response['status'] === 200) {
                    reloadJadwal(response, $('#hari').val());
                }
                $('#modal-schedule').modal('hide');
                console.log(response)
            } catch (e) {
                console.log(e)
            }
        }

        function reloadJadwal(response, hari) {
            let element = $('#panel-' + hari);
            element.empty();
            let list = '';
            if (response['payload']['data'].length > 0) {
                $.each(response['payload']['data'], function (k, v) {
                    list += singleList((k + 1), v, hari);
                });
                element.append(elTable(list));
                $('.btn-delete-jadwal').on('click', function () {
                    let id = this.dataset.id;
                    let day = this.dataset.day;
                    let data = {
                        id: id,
                        periode: $('#periode').val(),
                        hari: day,
                        kelas: $('#kelas').val(),
                        semester: $('#semester').val(),
                    };
                    deleteJadwal(data);
                })
            }else {
                element.append(elEmpty());
            }
        }

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve'
            });

            getList();

            $('.btn-add-subject').on('click', function (e) {
                e.preventDefault()
                $('#modal-schedule').modal('show');
            });

            $('#periode').on('change', function () {
                getList();
            });

            $('#kelas').on('change', function () {
                getList();
            });

            $('#semester').on('change', function () {
                getList();
            });

            $('.btn-save-subject').on('click', function () {
                addJadwal()

            });
        });
    </script>
@endsection

