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
            'title' => 'Edit'
        ],
    ];
@endphp
@section('content-title')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Halaman Edit Admin</h4>
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
            <form action="/admin/patch" method="POST">
                <x-card title="Form Data Guru" class="mt-3" :footer="true">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                    <x-form.input id="username" name="username" label="Username" value="{{ $data->user->username }}"/>
                    <x-form.input id="name" name="name" label="Nama Lengkap" value="{{ $data->nama }}"/>
                    <x-form.input type="password" id="password" name="password" label="Password"/>
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
