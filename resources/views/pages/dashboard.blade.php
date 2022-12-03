@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center" style="margin-top: 25vh">
            <div class="col-md-8 text-center">
                <img src="{{ asset('img/logo.png') }}" class="mb-4" style="max-height: 20vh" />
                <h3>Selamat Datang di Sistem Penilaian Kepala Sekolah</h3>
                <h4>PC LP Ma’arif NU Lamongan</h4>
            </div>
        </div>
    </div>
@endsection
