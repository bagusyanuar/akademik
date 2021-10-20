@extends('main.layouts')

@php
    $breadcrumb_item = [
        [
            'link' => '/dashboard',
            'title' => 'Dashboard'
        ],
        [
            'link' => '/siswa',
            'title' => 'Siswa'
        ],
        [
            'link' => '/',
            'title' => 'Tambah'
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
@endsection
@section('content-title')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Halaman Tambah Siswa</h4>
        <x-breadcrumb :item="$breadcrumb_item"></x-breadcrumb>
    </div>
@endsection

@section('content')
    @if(Session::has('success'))
        <x-alert class="alert-success" title="Berhasil" description="{{ Session::get('success') }}"/>
    @endif

    @if(Session::has('failed'))
        <x-alert class="alert-danger" title="Gagal" description="{{ Session::get('failed') }}"/>
    @endif
    <div class="row justify-content-center">
        <div class="col-6">
            <form action="/siswa/store" method="POST">
                <x-card title="Form Data Orang Tua Siswa" class="mt-3" :footer="true">
                    @csrf
                    <x-form.input id="name" name="name" label="Nama Lengkap"/>
                    <div class="form-group w-100">
                        <label for="kelas">Kelas</label>
                        <x-form.select2 id="kelas" name="kelas">
                            @foreach($data_kelas as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                            @endforeach
                        </x-form.select2>
                    </div>
                    <div class="form-group w-100">
                        <label for="orang_tua">Orang Tua</label>
                        <x-form.select2 id="orang_tua" name="orang_tua">
                            <option value="">--Pilih Orang Tua---</option>
                            @foreach($data_orang_tua as $orang_tua)
                                <option value="{{ $orang_tua->id }}">{{ $orang_tua->nama }}</option>
                            @endforeach
                        </x-form.select2>
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir">Kelas</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir">
                    </div>
                    <x-form.textarea id="alamat" name="alamat" label="Alamat"></x-form.textarea>
                    <x-slot name="footer_slot">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-send mr-1"></i>Simpan</button>
                        </div>
                    </x-slot>
                </x-card>
            </form>
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
