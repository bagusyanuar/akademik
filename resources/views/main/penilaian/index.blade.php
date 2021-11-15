@extends('main.layouts')

@php
    $breadcrumb_item = [
        [
            'link' => '/dashboard',
            'title' => 'Dashboard'
        ],
        [
            'link' => '/',
            'title' => 'Penilaian'
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
@endsection
@section('content-title')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Halaman Penilaian</h4>
        <x-breadcrumb :item="$breadcrumb_item"></x-breadcrumb>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <x-card title="Form Penilaian" class="mt-3">
                <x-slot name="header_action">
                    <div class="d-flex">
                        <div class="d-flex align-items-center">
                            <span class="font-weight-bold mr-2">Periode : </span>
                            <a href="#" class="title-header-action font-weight-bold text-black-50">2021/2022</a>
                        </div>
                        <span class="font-weight-bold mr-2 ml-2">|</span>
                        <div class="d-flex align-items-center">
                            <span class="font-weight-bold mr-2">Semester : </span>
                            <a href="#" class="title-header-action font-weight-bold text-black-50">Semester 1</a>
                        </div>
                    </div>
                </x-slot>

                <div class="form-group w-100">
                    <label for="semester">Nama Siswa</label>
                    <x-form.select2 id="siswa" name="siswa">
                        @foreach($siswa as $value)
                            <option value="{{ $value->id }}">{{ $value->nama }}</option>
                        @endforeach
                    </x-form.select2>
                </div>
                <hr/>
                <div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mata Pelajaran</th>
                            <th scope="col">Nilai</th>
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

    <div class="modal fade" id="modal-nilai" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
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
                    <input type="hidden" id="idPelajaran" value="">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group w-100">
                                <label for="nilai">Nilai</label>
                                <input type="number" id="nilai" name="nilai" class="form-control" value="0">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary btn-save">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/helper/helper.js') }}"></script>
    <script>
        async function getNilai() {
            let el = $('#panel_nilai');
            el.empty();
            try {
                let siswa = $('#siswa').val();
                let periode = 1;
                let semester = 1;
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

        async function saveNilai() {
            try {
                let siswa = $('#siswa').val();
                let pelajaran = $('#idPelajaran').val();
                let nilai = $('#nilai').val();
                let response = await $.post('/penilaian/saveNilai', {
                    '_token': '{{ csrf_token() }}',
                    siswa, pelajaran, nilai
                });
                if(response['status'] === 200) {
                    $('#modal-nilai').modal('hide');
                    getNilai()

                }else {
                    sweetAlertMessage('Peringatan!', response['msg'], 'warning')
                }
                console.log(response)
            } catch (e) {
                sweetAlertMessage('Peringatan!', 'Error', 'error')
            }
        }

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve'
            });

            $('#siswa').on('change', function () {
                getNilai();
            });
            getNilai();

            $('.btn-save').on('click', async function () {
                confirmSweetAlert('Konfirmasi','Yakin Ingin Merubah Nilai?', function () {
                    saveNilai();
                })
            })
        });
    </script>
@endsection

