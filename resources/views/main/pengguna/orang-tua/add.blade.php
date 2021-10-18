@extends('main.layouts')

@php
    $breadcrumb_item = [
        [
            'link' => '/dashboard',
            'title' => 'Dashboard'
        ],
        [
            'link' => '/orang-tua',
            'title' => 'Orang Tua Siswa'
        ],
        [
            'link' => '/',
            'title' => 'Tambah'
        ],
    ];
@endphp
@section('content-title')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Halaman Tambah Orang Tua Siswa</h4>
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
            <form action="/orang-tua/store" method="POST">
                <x-card title="Form Data Orang Tua Siswa" class="mt-3" :footer="true">
                    @csrf
                    <x-form.input id="username" name="username" label="Username"/>
                    <x-form.input id="name" name="name" label="Nama Lengkap"/>
                    <x-form.input type="password" id="password" name="password" label="Password"/>
                    <x-form.input type="number" id="no_hp" name="no_hp" label="No. Hp"/>
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
