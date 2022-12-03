@extends('layouts.app')

@section('title', 'Perangkingan Tingkat Kabupaten')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row mb-3 justify-content-center">
            <div class="col text-center">
                <h1 class="h3 mb-2 text-gray-800">Perangkingan Tingkat Kabupaten</h1>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="{{ url('hitung-kabupaten') }}">
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

                            <button class="btn btn-primary mt-3" type="submit">Lihat Perangkingan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if (!empty($rangking))
            <div class="row mb-3">
                <div class="col-md-12 table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="bg-success text-white text-center">
                                <th width="3%">No</th>
                                <th>Nama Kecamatan</th>
                                <th>Nama Sekolah</th>
                                <th>Nama Kepala Sekolah</th>
                                <th>Nilai</th>
                                <th>Rangking</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rangking as $rk)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rk->nama_kecamatan }}</td>
                                    <td>{{ $rk->nama_sekolah }}</td>
                                    <td>{{ $rk->nama_lengkap }}</td>
                                    <td>{{ $rk->nilai }}</td>
                                    <td>{{ $loop->iteration }}</td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="5"></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
