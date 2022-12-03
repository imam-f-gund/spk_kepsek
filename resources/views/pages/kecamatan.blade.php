@extends('layouts.app')

@section('title', 'Data Kecamatan')

@section('content')
    <div class="container-fluid">
        <div class="modal fade" id="tambahKecamatan" tabindex="-1" role="dialog" aria-labelledby="tambahKecamatanLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahKecamatanLabel">Tambah Kecamatan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('kecamatan') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_kecamatan">Nama Kecamatan</label>
                                <input type="text" class="form-control" id="nama_kecamatan" name="nama_kecamatan">
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

        <div class="modal fade" id="ubahKecamatan" tabindex="-1" role="dialog" aria-labelledby="tambahKecamatanLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahKecamatanLabel">Ubah Kecamatan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('kecamatan') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_kecamatan">Nama Kecamatan</label>
                                <input type="text" class="form-control" id="nama_kecamatan" name="nama_kecamatan">
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
                <h1 class="h3 mb-2 text-gray-800">Data Kecamatan</h1>
            </div>
            <div class="col">
                <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                    data-target="#tambahKecamatan">
                    Tambah Kecamatan
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
                                        <th>Nama Kecamatan</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kecamatan as $data)
                                        <tr>
                                            <td>{{ $data->nama_kecamatan }}</td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm"
                                                    onclick="fungsiEdit('{{ $data->id }}|{{ $data->nama_kecamatan }}')"
                                                    data-toggle="modal" data-target="#ubahKecamatan">
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <form action="{{ url('kecamatan/' . $data->id) }}" class="d-inline"
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
            $('#ubahKecamatan form').attr('action', "{{ url('kecamatan') }}/" + data[0]);
            $('#ubahKecamatan .modal-body #nama_kecamatan').val(data[1]);
        }
    </script>
@endsection
