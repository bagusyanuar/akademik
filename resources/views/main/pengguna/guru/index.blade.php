@extends('main.layouts')

@php
    $breadcrumb_item = [
        [
            'link' => '/dashboard',
            'title' => 'Dashboard'
        ],
        [
            'link' => '/',
            'title' => 'Guru'
        ],
    ];
@endphp
@section('css')
    <style>
        .select2-selection {
            height: 40px !important;
            line-height: 40px !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('/adminlte/plugins/datatables/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content-title')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Halaman Data Guru</h4>
        <x-breadcrumb :item="$breadcrumb_item"></x-breadcrumb>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <x-card title="Data guru" class="mt-3">
                <x-slot name="header_action">
                    <a href="/guru/tambah" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>Tambah</a>
                </x-slot>
                <table id="my-table" class="table display">
                    <thead>
                    <tr>
                        <th width="8%" class="text-center">#</th>
                        <th width="15%">Username</th>
                        <th width="30%">Nama Lengkap</th>
                        <th width="15%">Mata Pelajaran</th>
                        <th width="15%">Wali Kelas</th>
                        <th width="15%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $guru)
                        <tr>
                            <td class="text-center">{{ $loop->index +1 }}</td>
                            <td>{{ $guru->user->username }}</td>
                            <td>{{ $guru->nama }}</td>
                            <td>
                                @if($guru->mataPelajaran === null)
                                    -
                                @else
                                    {{ $guru->mataPelajaran->nama }}
                                @endif
                            </td>
                            <td>
                                @if($guru->kelas === null)
                                    <button type="button" class="btn btn-info btn-wali btn-sm"
                                            data-guru="{{$guru->id}}">Tambah Kelas
                                    </button>
                                @else
                                    <div class="dropdown">
                                        <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            {{ $guru->kelas->nama }}
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <button class="dropdown-item btn-wali" data-guru="{{$guru->id}}"
                                                    data-wali="{{ $guru->kelas->id }}">Ganti
                                            </button>
                                            <button class="dropdown-item btn-drop-wali" data-guru="{{$guru->id}}">Hapus</button>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <a href="/guru/edit/{{ $guru->id }}" class="btn btn-warning btn-sm"><i
                                        class="fa fa-edit"></i></a>
                                <button type="button" class="btn btn-danger btn-delete btn-sm"
                                        data-id="{{$guru->user->id}}"><i
                                        class="fa fa-trash"></i></button>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </x-card>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Wali Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="type" name="type" value="add">
                    <input type="hidden" id="guru" name="guru" value="">
                    <div class="form-group w-100">
                        <label for="kelas">Kelas</label>
                        <x-form.select2 id="kelas" name="kelas">
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </x-form.select2>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-kelas">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script src="{{ asset('/adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('/adminlte/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/helper/helper.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.dropdown-toggle').dropdown()
            $('#my-table').DataTable();
            $('.select2').select2({
                width: 'resolve'
            });

            $('.btn-wali').on('click', function () {
                let data_guru = this.dataset.guru;
                let data_wali = this.dataset.wali;
                let type = 'add';
                if (data_wali !== undefined) {
                    type = 'edit';
                    $('#kelas').select2("val", data_wali);
                } else {
                    $('#kelas').select2("val", '');
                }
                $('#guru').val(data_guru);
                console.log(data_guru, data_wali);
                $('#type').val(type);
                $('#myModal').modal('show')
            });

            $('.btn-delete').on('click', function () {
                let id = this.dataset.id;
                confirmSweetAlert('Konfirmasi', 'Apakah Anda Yakin Menghapus Data?', async function () {
                    try {
                        let data = {
                            '_token': '{{ csrf_token() }}'
                        };
                        let response = await $.post('/guru/destroy/' + id, data);
                        if (response['code'] === 200) {
                            window.location.href = '/guru';
                        } else {
                            sweetAlertMessage('Peringatan!', response['msg'], 'warning')
                        }
                    } catch (e) {
                        console.log(e)
                    }
                })
            });

            $('#btn-kelas').on('click', async function () {
                let data = {
                    '_token': '{{ csrf_token() }}',
                    kelas: $('#kelas').val(),
                    id: $('#guru').val()
                };
                let response = await $.post('/guru/kelas/', data);
                if (response['code'] === 200) {
                    window.location.href = '/guru';
                } else if (response['code'] === 202) {
                    sweetAlertMessage('Peringatan!', response['msg'], 'warning')
                } else {
                    sweetAlertMessage('Peringatan!', response['msg'], 'warning')
                }
            });

            $('.btn-drop-wali').on('click', async function () {
                let data = {
                    '_token': '{{ csrf_token() }}',
                    id: this.dataset.guru
                };
                let response = await $.post('/guru/kelas/drop', data);
                if (response['code'] === 200) {
                    window.location.href = '/guru';
                } else {
                    sweetAlertMessage('Peringatan!', response['msg'], 'warning')
                }
            });
        });
    </script>
@endsection

