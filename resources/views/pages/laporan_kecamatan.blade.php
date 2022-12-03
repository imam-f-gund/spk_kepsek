@extends('layouts.app')

@section('title', 'Laporan Tingkat Kecamatan')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row mb-3 justify-content-center">
            <div class="col text-center">
                <h1 class="h3 mb-2 text-gray-800">Laporan Tingkat Kecamatan</h1>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="{{ url('download/kecamatan') }}">
                            @csrf
                            <div class="form-group">
                                <label>Pilih Periode</label>
                                <select class="form-control selectpicker" data-live-search="true" id="id_periode"
                                    name="id_periode">
                                    @foreach ($periode as $pd)
                                        <option value="{{ $pd->id }}">{{ $pd->nama_periode }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Pilih Periode</label>
                                <select class="form-control selectpicker" data-live-search="true" id="id_kecamatan"
                                    name="id_kecamatan">
                                    @foreach ($kecamatan as $pd)
                                        <option value="{{ $pd->id }}">{{ $pd->nama_kecamatan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button class="btn btn-primary mt-3" type="submit">Download Report</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
