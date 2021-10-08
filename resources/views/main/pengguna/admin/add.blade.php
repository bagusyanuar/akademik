@extends('main.layouts')

@php
    $breadcrumb_item = [
        [
            'link' => '/dashboard',
            'title' => 'Dashboard'
        ],
        [
            'link' => '/admin',
            'title' => 'Admin'
        ],
        [
            'link' => '/',
            'title' => 'Tambah'
        ],
    ];
@endphp
@section('content-title')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Halaman Tambah Guru</h4>
        <x-breadcrumb :item="$breadcrumb_item"></x-breadcrumb>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <x-card title="Form Data Guru" class="mt-3" :footer="true">
                <form action="/admin/store" method="POST">
                    @csrf
                    <x-form.input id="username" name="username" label="Username"/>
                    <x-form.input type="password" id="password" name="password" label="Password"/>
                    <x-form.input id="name" name="name" label="Nama Lengkap"/>
                    <x-slot name="footer_slot">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-send mr-1"></i>Simpan</button>
                        </div>
                    </x-slot>
                </form>
            </x-card>
        </div>
    </div>
@endsection
