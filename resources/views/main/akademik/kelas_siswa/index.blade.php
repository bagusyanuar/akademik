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
        <h4 class="mb-0">Halaman Data Kelas Siswa</h4>
        <x-breadcrumb :item="$breadcrumb_item"></x-breadcrumb>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <x-card title="Data Kelas Siswa" class="mt-3">
                {{--                <x-slot name="header_action">--}}
                {{--                    <a href="/mata-pelajaran/tambah" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>Tambah</a>--}}
                {{--                </x-slot>--}}

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
        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve'
            });

        });
    </script>
@endsection

