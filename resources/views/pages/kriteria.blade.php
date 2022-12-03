@extends('layouts.app')

@section('title', 'Data Kriteria')

@section('content')
    <div class="container-fluid">
        <div class="modal fade" id="tambahKriteria" tabindex="-1" role="dialog" aria-labelledby="tambahKriteriaLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahKriteriaLabel">Tambah Kriteria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('kriteria') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_kriteria">Nama Kriteria</label>
                                <input type="text" class="form-control" id="nama_kriteria" name="nama_kriteria">
                            </div>
                            <div class="form-group">
                                <label for="bobot_kriteria">Bobot Kriteria</label>
                                <input type="number" class="form-control" id="bobot_kriteria" name="bobot_kriteria"
                                    placeholder="Masukkan angka dalam persen 0-100 (Contoh : 10)">
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

        <div class="modal fade" id="tambahIndikator" tabindex="-1" role="dialog" aria-labelledby="tambahIndikatorLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahIndikatorLabel">Tambah Indikator</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('indikator') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_kriteria">Nama Kriteria</label>
                                <select type="text" class="form-control selectpicker" data-live-search="true"
                                    id="nama_kriteriacek" name="nama_kriteria" onchange="kricek()">
                                    @foreach ($kriteria as $kr)
                                        <option value="{{ $kr->id }}">{{ $kr->nama_kriteria }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Indikator</label>
                                <button type="button" class="btn btn-sm btn-primary float-right"
                                    onclick="tambah()">Tambah</button>
                            </div>
                            <div id="tampung">
                                @php
                                    if ($kriteria->count() > 0) {
                                        $indikator = App\Models\Indikator::where('id_kriteria', $kriteria[0]->id)->get();
                                    } else {
                                        $indikator = [];
                                    }
                                @endphp
                                @forelse($indikator as $ind)
                                    <div class="form-row mb-3">
                                        <div class="col-7">
                                            <input type="text" class="form-control" placeholder="Nama Indikator"
                                                name="nama_indikator[]" value="{{ $ind->nama_indikator }}">
                                        </div>
                                        <div class="col">
                                            <input type="number" class="form-control" placeholder="Nilai Indikator"
                                                name="nilai_indikator[]" value="{{ $ind->nilai_indikator }}">
                                        </div>
                                        <div class="col-1">
                                            <button type="button" class="mt-1 btn btn-danger btn-sm hapusIn">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="form-row mb-3">
                                        <div class="col-7">
                                            <input type="text" class="form-control" placeholder="Nama Indikator"
                                                name="nama_indikator[]">
                                        </div>
                                        <div class="col">
                                            <input type="number" class="form-control" placeholder="Nilai Indikator"
                                                name="nilai_indikator[]">
                                        </div>
                                        <div class="col-1">
                                            <button type="button" class="mt-1 btn btn-danger btn-sm hapusIn">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforelse
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

        <div class="modal fade" id="ubahKriteria" tabindex="-1" role="dialog" aria-labelledby="tambahKriteriaLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahKriteriaLabel">Ubah Kriteria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('kriteria') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_kriteria">Nama Kriteria</label>
                                <input type="text" class="form-control" id="nama_kriteria" name="nama_kriteria">
                            </div>
                            <div class="form-group">
                                <label for="bobot_kriteria">Bobot Kriteria</label>
                                <input type="number" class="form-control" id="bobot_kriteria" name="bobot_kriteria"
                                    placeholder="Masukkan angka dalam persen 0-100 (Contoh : 10)">
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
                <h1 class="h3 mb-2 text-gray-800">Data Kriteria</h1>
            </div>
            <div class="col">

                <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                    data-target="#tambahIndikator">
                    Tambah Indikator
                </button>
                <button type="button" class="btn btn-primary mr-2 float-right" data-toggle="modal"
                    data-target="#tambahKriteria">
                    Tambah Kriteria
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
                                        <th>Kode</th>
                                        <th>Nama Kriteria</th>
                                        <th>Bobot</th>
                                        <th>Indikator</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kriteria as $kr)
                                        <tr>
                                            <td>C{{ $loop->iteration }}</td>
                                            <td>{{ $kr->nama_kriteria }}</td>
                                            <td>{{ $kr->bobot_kriteria }}</td>
                                            <td>
                                                <table class="table table-bordered table-striped">
                                                    @php
                                                        $indikator = App\Models\Indikator::where('id_kriteria', $kr->id)->get();
                                                    @endphp
                                                    @foreach ($indikator as $ind)
                                                        <tr>
                                                            <td>{{ $ind->nama_indikator }}</td>
                                                            <td>{{ $ind->nilai_indikator }}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td class="">
                                                <button type="button" class="btn btn-info btn-sm"
                                                    onclick="fungsiIndikator('{{ $kr->id }}')" data-toggle="modal"
                                                    data-target="#tambahIndikator">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>

                                                <button type="button" class="btn btn-warning btn-sm"
                                                    onclick="fungsiEdit('{{ $kr->id }}|{{ $kr->nama_kriteria }}|{{ $kr->bobot_kriteria }}')"
                                                    data-toggle="modal" data-target="#ubahKriteria">
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <form action="{{ url('kriteria/' . $kr->id) }}" class="d-inline"
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
        function fungsiIndikator(id) {
            $('#nama_kriteriacek').val(id);
            $('.selectpicker').selectpicker('refresh');
            kricek();
        }

        function tambah() {
            var row = `
                <div class="form-row mb-3">
                    <div class="col-7">
                        <input type="text" class="form-control" placeholder="Nama Indikator"
                            name="nama_indikator[]">
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" placeholder="Nilai Indikator"
                            name="nilai_indikator[]">
                    </div>
                    <div class="col-1">
                        <button type="button" class="mt-1 btn btn-danger btn-sm hapusIn">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            $('#tambahIndikator .modal-body #tampung').append(row);
        }

        function kricek() {
            var id = $('#nama_kriteriacek').val();
            $.ajax({
                url: "{{ url('cek-kriteria') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function(data) {
                    if (data.length > 0) {
                        $('#tambahIndikator .modal-body #tampung').html('');
                        $.each(data, function(i, v) {
                            var row = `
                                <div class="form-row mb-3">
                                    <div class="col-7">
                                        <input type="text" class="form-control" placeholder="Nama Indikator"
                                            name="nama_indikator[]" value="${v.nama_indikator}">
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control" placeholder="Nilai Indikator"
                                            name="nilai_indikator[]" value="${v.nilai_indikator}">
                                    </div>
                                    <div class="col-1">
                                        <button type="button" class="mt-1 btn btn-danger btn-sm hapusIn">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            `;
                            $('#tambahIndikator .modal-body #tampung').append(row);
                        });
                    } else {
                        $('#tambahIndikator .modal-body #tampung').html('');
                        var row = `
                            <div class="form-row mb-3">
                                <div class="col-7">
                                    <input type="text" class="form-control" placeholder="Nama Indikator"
                                        name="nama_indikator[]">
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" placeholder="Nilai Indikator"
                                            name="nilai_indikator[]">
                                    </div>
                                    <div class="col-1">
                                        <button type="button" class="mt-1 btn btn-danger btn-sm hapusIn">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>`;
                        $('#tambahIndikator .modal-body #tampung').append(row);
                    }

                }
            });
        }

        $(document).on('click', '.hapusIn', function() {
            $(this).parent().parent().remove();
        });

        function fungsiEdit(data) {
            var data = data.split('|');
            $('#ubahKriteria form').attr('action', "{{ url('kriteria') }}/" + data[0]);
            $('#ubahKriteria .modal-body #nama_kriteria').val(data[1]);
            $('#ubahKriteria .modal-body #bobot_kriteria').val(data[2]);
        }
    </script>
@endsection
