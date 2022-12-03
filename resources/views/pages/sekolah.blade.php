@extends('layouts.app')

@section('title', 'Data Sekolah')

@section('content')
    <div class="container-fluid">
        <div class="modal fade" id="tambahSekolah" tabindex="-1" role="dialog" aria-labelledby="tambahSekolahLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahSekolahLabel">Tambah Sekolah</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('sekolah') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="id_kecamatan">Nama Kecamatan</label>
                                <select type="text" class="form-control selectpicker" data-live-search="true"
                                    id="id_kecamatan" name="id_kecamatan">
                                    @foreach ($kecamatan as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_kecamatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_sekolah">Nama Sekolah</label>
                                <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah">
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

        <div class="modal fade" id="ubahSekolah" tabindex="-1" role="dialog" aria-labelledby="tambahSekolahLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahSekolahLabel">Ubah Sekolah</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('sekolah') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="id_kecamatan">Nama Kecamatan</label>
                                <select type="text" class="form-control selectpicker" data-live-search="true"
                                    id="id_kecamatan" name="id_kecamatan">
                                    @foreach ($kecamatan as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_kecamatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_sekolah">Nama Sekolah</label>
                                <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah">
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
                <h1 class="h3 mb-2 text-gray-800">Data Sekolah</h1>
            </div>
            <div class="col">
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#tambahSekolah">
                    Tambah Sekolah
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
                                        <th>Nama Sekolah</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sekolah as $data)
                                        <tr>
                                            <td>{{ $data->kecamatan->nama_kecamatan }}</td>
                                            <td>{{ $data->nama_sekolah }}</td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm"
                                                    onclick="fungsiEdit('{{ $data->id }}|{{ $data->nama_sekolah }}|{{ $data->id_kecamatan }}')"
                                                    data-toggle="modal" data-target="#ubahSekolah">
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <form action="{{ url('sekolah/' . $data->id) }}" class="d-inline"
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
            console.log(data);
            $('#ubahSekolah form').attr('action', "{{ url('sekolah') }}/" + data[0]);
            $('#ubahSekolah .modal-body #nama_sekolah').val(data[1]);
            $('#ubahSekolah .modal-body #id_kecamatan').val(data[2]);
            $('.selectpicker').selectpicker('refresh');
        }
    </script>
@endsection
