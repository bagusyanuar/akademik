@extends('main.layouts')

@php
    $breadcrumb_item = [
        [
            'link' => '/dashboard',
            'title' => 'Dashboard'
        ],
        [
            'link' => '/',
            'title' => 'Jadwal Pelajaran'
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
        <h4 class="mb-0">Halaman Jadwal Pelajaran</h4>
        <x-breadcrumb :item="$breadcrumb_item"></x-breadcrumb>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <x-card title="Data Mata Pelajaran" class="mt-3">
                {{--                <x-slot name="header_action">--}}
                {{--                    <a href="/mata-pelajaran/tambah" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>Tambah</a>--}}
                {{--                </x-slot>--}}

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
                <div class="row">
                    <div class="col-6">
                        <div class="card" style="min-height: 300px">
                            <div class="card-header bg-primary">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="font-weight-bold">Senin</span>
                                    <button class="btn btn-outline-light btn-sm btn-add-subject" data-day="senin"><i
                                            class="fa fa-plus mr-1"></i>Tambah
                                    </button>
                                </div>
                            </div>
                            <div class="card-body d-flex justify-content-center" id="panel-senin">
                                <div class="d-block text-center">
                                    <span class="font-weight-bold text-center d-block mb-1">Jadwal Belum Tersedia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card" style="min-height: 300px">
                            <div class="card-header bg-primary">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="font-weight-bold">Selasa</span>
                                    <button class="btn btn-outline-light btn-sm btn-add-subject" data-day="selasa"><i
                                            class="fa fa-plus mr-1"></i>Tambah
                                    </button>
                                </div>
                            </div>
                            <div class="card-body d-flex justify-content-center" id="panel-selasa">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card" style="min-height: 300px">
                            <div class="card-header bg-primary">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="font-weight-bold">Rabu</span>
                                    <button class="btn btn-outline-light btn-sm btn-add-subject" data-day="rabu"><i
                                            class="fa fa-plus mr-1"></i>Tambah
                                    </button>
                                </div>
                            </div>
                            <div class="card-body d-flex justify-content-center" id="panel-rabu">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card" style="min-height: 300px">
                            <div class="card-header bg-primary">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="font-weight-bold">Kamis</span>
                                    <button class="btn btn-outline-light btn-sm btn-add-subject" data-day="kamis"><i
                                            class="fa fa-plus mr-1"></i>Tambah
                                    </button>
                                </div>
                            </div>
                            <div class="card-body d-flex justify-content-center" id="panel-kamis">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card" style="min-height: 300px">
                            <div class="card-header bg-primary">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="font-weight-bold">Jumat</span>
                                    <button class="btn btn-outline-light btn-sm btn-add-subject" data-day="jumat"><i
                                            class="fa fa-plus mr-1"></i>Tambah
                                    </button>
                                </div>
                            </div>
                            <div class="card-body d-flex justify-content-center" id="panel-jumat">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card" style="min-height: 300px">
                            <div class="card-header bg-primary">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="font-weight-bold">Sabtu</span>
                                    <button class="btn btn-outline-light btn-sm btn-add-subject" data-day="sabtu"><i
                                            class="fa fa-plus mr-1"></i>Tambah
                                    </button>
                                </div>
                            </div>
                            <div class="card-body d-flex justify-content-center" id="panel-sabtu">
                            </div>
                        </div>
                    </div>
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
                    <div class="form-group w-100" id="panel-mapel">
                        <label for="mata_pelajaran">Mata Pelajaran</label>
                        <x-form.select2 id="mata_pelajaran" name="mata_pelajaran">
                        </x-form.select2>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="mulai">Jam Mulai</label>
                                <input type="time" id="mulai" name="mulai" class="form-control" value="07:00">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="selesai">Jam Selesai</label>
                                <input type="time" id="selesai" name="selesai" class="form-control" value="07:00">
                            </div>
                        </div>
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

        function singleList(index, value, hari) {
            let {mulai, selesai, id} = value;
            return '<tr>' +
                '<th scope="row">' + index + '</th>' +
                '<td>' + value['mata_pelajaran']['nama'] + '</td>' +
                '<td>' + mulai.substr(0, 5) + ' - ' + selesai.substr(0, 5) + '</td>' +
                '<td><button type="button" class="btn btn-sm btn-danger btn-delete-jadwal" data-id="' + id + '" data-day="' + hari + '"><i class="fa fa-trash"></i></button></td>' +
                '</tr>';
        }

        function elEmpty() {
            return '<div class="d-block text-center">' +
                '<span class="font-weight-bold text-center d-block mb-1">Jadwal Belum Tersedia</span>' +
                '</div>';
        }

        function deleteJadwal(formData) {
            confirmSweetAlert('Konfirmasi', 'Apakah Anda Yakin Menghapus Data?', async function () {
                try {
                    let data = {
                        '_token': '{{ csrf_token() }}',
                        hari: formData['hari'],
                        periode: formData['periode'],
                        kelas: formData['kelas'],
                        semester: formData['semester'],
                        id: formData['id'],
                    };
                    let response = await $.post('/jadwal/destroy/', data);
                    console.log(response)
                    if (response['status'] === 200) {
                        reloadJadwal(response, formData['hari']);
                    } else {
                        sweetAlertMessage('Peringatan!', response['msg'], 'warning')
                    }
                } catch (e) {
                    console.log(e)
                }
            });
        }

        async function getJadwal() {
            try {
                let periode = $('#periode').val();
                let kelas = $('#kelas').val();
                let semester = $('#semester').val();
                let availableDay = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
                let response = await $.get('/jadwal/list?periode=' + periode + '&kelas=' + kelas + '&semester=' + semester);
                let data = response['payload']['data'];
                $.each(availableDay, function (k, v) {
                    let jadwal = data[v];
                    let element = $('#panel-' + v);
                    element.empty();
                    if (jadwal !== undefined) {
                        let list = '';
                        $.each(jadwal, function (key_jadwal, data) {
                            list += singleList((key_jadwal + 1), data, v);
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
                    } else {
                        element.append(elEmpty());
                    }
                    console.log(jadwal)
                });
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
                sweetAlertMessage('Gagal', 'Gagal Menambahan Jadwal!', 'error');
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

        function elCombo(data)
        {
            console.log(data)
            let element = $('#panel-mapel');
            element.empty();
            let parent = '<label for="mata_pelajaran">Mata Pelajaran</label>' +
                '<select class="select2" name="mata_pelajaran" id="mata_pelajaran" style="width: 100%;"></select>';
            element.append(parent);
            if(data.length > 0) {
                let child = $('#mata_pelajaran');
                $.each(data, function (k, v) {

                    child.append('<option value="'+v['mata_pelajaran_id']+'">'+v['mata_pelajaran']['nama']+'</option>')
                });
            }
            $('.select2').select2({
                width: 'resolve'
            });
        }
        async function getSubjectBy()
        {
            try {
                let periode = $('#periode').val();
                let kelas = $('#kelas').val();
                let semester = $('#semester').val();
                let response = await $.get('/jadwal/listBy?periode=' + periode + '&kelas=' + kelas + '&semester=' + semester);
                if(response['status'] === 200) {
                    let data = response['payload']['data'];
                    elCombo(data);
                }
                console.log(response)
            } catch (e) {
                console.log(e)
            }
        }

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve'
            });

            getJadwal();

            $('.btn-add-subject').on('click', function () {
                let day = this.dataset.day;
                $('#title-hari').html(day);
                $('#hari').val(day);
                $('#modal-schedule').modal('show');
            });

            $('.btn-save-subject').on('click', function () {
                addJadwal();
            });

            $('#periode').on('change', function () {
                getJadwal();
            });

            $('#kelas').on('change', function () {
                getJadwal();
            });

            $('#semester').on('change', function () {
                getJadwal();
            });
            $('#modal-schedule').on('show.bs.modal', function () {
                getSubjectBy();
            });
        });
    </script>
@endsection

