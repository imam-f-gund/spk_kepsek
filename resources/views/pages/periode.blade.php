@extends('layouts.app')

@section('title', 'Data Periode')

@section('content')
    <div class="container-fluid">
        <div class="modal fade" id="tambahPeriode" tabindex="-1" role="dialog" aria-labelledby="tambahPeriodeLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahPeriodeLabel">Tambah Periode</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('periode') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_periode">Nama Periode</label>
                                <input type="text" class="form-control" id="nama_periode" name="nama_periode">
                            </div>
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <input class="form-control datepicker" id="tahun" name="tahun">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ubahPeriode" tabindex="-1" role="dialog" aria-labelledby="tambahPeriodeLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahPeriodeLabel">Ubah Periode</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('periode') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_periode">Nama Periode</label>
                                <input type="text" class="form-control" id="nama_periode" name="nama_periode">
                            </div>
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <input type="text" class="form-control datepicker" id="tahun" name="tahun">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col">
                <h1 class="h3 mb-2 text-gray-800">Data Periode</h1>
            </div>
            <div class="col">
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#tambahPeriode">
                    Tambah Periode
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead class="bg-success text-white text-center">
                                    <tr>
                                        <th>Nama Periode</th>
                                        <th>Tahun</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($periode as $data)
                                        <tr>
                                            <td>{{ $data->nama_periode }}</td>
                                            <td>{{ date('Y', strtotime($data->tahun)) }}</td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm"
                                                    onclick="fungsiEdit('{{ $data->id }}|{{ $data->nama_periode }}|{{ date('Y', strtotime($data->tahun)) }}')"
                                                    data-toggle="modal" data-target="#ubahPeriode">
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <form action="{{ url('periode/' . $data->id) }}" class="d-inline"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger btn-delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function fungsiEdit(data) {
            var data = data.split('|');
            $('#ubahPeriode form').attr('action', "{{ url('periode') }}/" + data[0]);
            $('#ubahPeriode .modal-body #nama_periode').val(data[1]);
            $('#ubahPeriode .modal-body #tahun').val(data[2]);
        }

        $(".datepicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
    </script>
@endsection
