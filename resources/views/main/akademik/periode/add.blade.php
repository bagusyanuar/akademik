@extends('main.layouts')

@php
    $breadcrumb_item = [
        [
            'link' => '/dashboard',
            'title' => 'Dashboard'
        ],
        [
            'link' => '/periode',
            'title' => 'Periode'
        ],
        [
            'link' => '/',
            'title' => 'Tambah'
        ],
    ];
@endphp
@section('content-title')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Halaman Tambah Periode Belajar Mengajar</h4>
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
            <form action="/periode/store" method="POST">
                <x-card title="Form Data Periode Belajar Mengajar" class="mt-3" :footer="true">
                    @csrf
                    <div class="d-flex align-items-center justify-content-center">
                        <x-form.input type="number" id="start" name="start" label="Awal"/>
                        <span class="ml-2 mr-2 font-weight-bold">/</span>
                        <x-form.input type="number" id="end" name="end" label="Akhir"/>
                    </div>

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
