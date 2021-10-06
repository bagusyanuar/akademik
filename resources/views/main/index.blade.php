@extends('main.layouts')

@php
    $breadcrumb_item = [
        [
            'link' => '/',
            'title' => 'Dashboard'
        ]
    ];
@endphp
@section('content-title')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Dashboard</h4>
        <x-breadcrumb :item="$breadcrumb_item"></x-breadcrumb>
    </div>
@endsection
@section('content')
@endsection
