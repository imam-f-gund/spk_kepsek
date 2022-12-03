@extends('layouts.app')

@section('title', 'Data Kepala Sekolah')

@section('content')
    <div class="container-fluid">
        <div class="modal fade" id="tambahPeriode" tabindex="-1" role="dialog" aria-labelledby="tambahPeriodeLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahPeriodeLabel">Tambah Kepala Sekolah</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('kepsek') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="id_sekolah">Nama Sekolah</label>
                                <select type="text" class="form-control selectpicker" data-live-search="true" id="id_sekolah"
                                    name="id_sekolah" onchange="kricek()">
                                    @foreach ($sekolah as $sh)
                                        <option value="{{ $sh->id }}">{{ $sh->nama_sekolah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap">
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea type="text" class="form-control" id="alamat" name="alamat"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="no_telp">Nomor Telfon</label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp">
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
                        <h5 class="modal-title" id="tambahPeriodeLabel">Ubah Kepala Sekolah</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('kepsek') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="id_sekolah">Nama Sekolah</label>
                                <select type="text" class="form-control selectpicker" data-live-search="true"
                                    id="id_sekolah" name="id_sekolah" onchange="kricek()">
                                    @foreach ($sekolah as $sh)
                                        <option value="{{ $sh->id }}">{{ $sh->nama_sekolah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap">
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea type="text" class="form-control" id="alamat" name="alamat"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="no_telp">Nomor Telfon</label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp">
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
                <h1 class="h3 mb-2 text-gray-800">Data Kepala Sekolah</h1>
            </div>
            <div class="col">
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#tambahPeriode">
                    Tambah Kepala Sekolah
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
                                        <th>Nama Sekolah</th>
                                        <th>Nama Lengkap</th>
                                        <th>Alamat</th>
                                        <th>No Telfon</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kepsek as $data)
                                        <tr>
                                            <td>{{ $data->sekolah->nama_sekolah }}</td>
                                            <td>{{ $data->nama_lengkap }}</td>
                                            <td>{{ $data->alamat }}</td>
                                            <td>{{ $data->no_telp }}</td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm"
                                                    onclick="fungsiEdit('{{ $data->id }}|{{ $data->id_sekolah }}|{{ $data->nama_lengkap }}|{{ $data->alamat }}|{{ $data->no_telp }}')"
                                                    data-toggle="modal" data-target="#ubahPeriode">
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <form action="{{ url('kepsek/' . $data->id) }}" class="d-inline"
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
            $('#ubahPeriode form').attr('action', "{{ url('kepsek') }}/" + data[0]);
            $('#ubahPeriode .modal-body #id_sekolah').val(data[1]);
            $('#ubahPeriode .modal-body #nama_lengkap').val(data[2]);
            $('#ubahPeriode .modal-body #alamat').text(data[3]);
            $('#ubahPeriode .modal-body #no_telp').val(data[4]);

            $('.selectpicker').selectpicker('refresh');
        }

        $(".datepicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
    </script>
@endsection
