@extends('layouts.app')

@section('title', 'Data Penilaian')

@section('content')
    <div class="container-fluid">
        @if (!empty(request('id_periode')))
            <div class="modal fade" id="tambahPenilaian" tabindex="-1" role="dialog"
                aria-labelledby="tambahPenilaianLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahPenilaianLabel">Tambah Penilaian</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ url('penilaian') }}" method="POST">
                            @csrf
                            <div class="modal-body px-4">
                                <input type="hidden" name="id_periode" id="id_periode" value="{{ $periode->id }}">
                                <div class="form-group">
                                    <label for="id_cari_kecamatan">Nama Kecamatan</label>
                                    <select type="text" class="form-control selectpicker" data-live-search="true"
                                        id="id_cari_kecamatan" name="id_cari_kecamatan" onchange="ubahkecamatan()">
                                        @foreach ($kecamatan as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_kecamatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="id_kepala_sekolah">Nama Kepala Sekolah</label>
                                    <select type="text" class="form-control selectpicker" data-live-search="true"
                                        id="id_kepala_sekolah" name="id_kepala_sekolah" disabled>
                                        @foreach ($kepsek as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_lengkap }} |
                                                {{ $item->sekolah->nama_sekolah }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="tempat_kriteria">
                                    @foreach ($kriteria->chunk(2) as $chunk)
                                        <div class="form-row mb-3">
                                            @foreach ($chunk as $kr)
                                                <div class="col-md-6">
                                                    <label>{{ $kr->nama_kriteria }}</label>
                                                    <input type="hidden" name="id_kriteria[]" value="{{ $kr->id }}" />
                                                    <select type="text" class="form-control selectpicker"
                                                        data-live-search="true" name="id_indikator[]"
                                                        id="kr{{ $kr->id }}">
                                                        @foreach ($kr->indikator as $ind)
                                                            <option value="{{ $ind->id }}">
                                                                {{ $ind->nama_indikator }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
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
        @endif

        @if (empty(request('id_periode')))
            <div class="periode">
                <div class="row mb-3">
                    <div class="col text-center">
                        <h1 class="h3 mb-2 text-gray-800">Pilih Periode</h1>
                    </div>
                </div>

                <div class="row">
                    @foreach ($periode as $pd)
                        <div class="col-md-4">
                            <button type="button" class="btn btn-link btn-block text-decoration-none text-black"
                                style="color: inherit;" onclick="tombolPeriode('{{ $pd->id }}')">
                                <div class="card w-100 h-100 text-center shadow mb-4">
                                    <div class="card-body">
                                        {{ $pd->nama_periode }}
                                    </div>
                                    <div class="card-footer bg-success text-white">
                                        {{ date('Y', strtotime($pd->tahun)) }}
                                    </div>
                                </div>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="penilaian">
                <!-- Page Heading -->
                <div class="row mb-3">
                    <div class="col">
                        <h1 class="h3 mb-2 text-gray-800" id="judul">Penilaian {{ $periode->nama_periode }}</h1>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#tambahPenilaian">
                            Tambah Penilaian
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="row justify-content-end">
                                        <form class="col-md-3 form-inline">
                                            <div class="input-group mb-3 float-right w-100">
                                                <input type="hidden" name="id_periode" value="{{ $periode->id }}">
                                                <select type="text" class="form-control selectpicker"
                                                    data-live-search="true" name="id_kecamatan">
                                                    @foreach ($kecamatan as $kc)
                                                        <option value="{{ $kc->id }}">{{ $kc->nama_kecamatan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Filter</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <table class="table table-bordered table-striped" id="dataTable" width="100%"
                                        cellspacing="0">
                                        <thead class="bg-success text-white text-center">
                                            <tr>
                                                <th>Nama Kepala Sekolah</th>
                                                @foreach ($kriteria as $kr)
                                                    <th>C{{ $loop->iteration }}</th>
                                                @endforeach
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($nilai as $data)
                                                <tr>
                                                    <td>
                                                        {{ $data->nama_lengkap }} <br>
                                                        ({{ $data->sekolah->nama_sekolah }})
                                                    </td>
                                                    @foreach ($data->nilai_kepsek as $nilai)
                                                        <td>
                                                            {{ $nilai->indikator->nama_indikator }}
                                                        </td>
                                                    @endforeach
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            onclick="fungsiEdit('{{ $data->id }}|{{ $periode->id }}')"
                                                            data-toggle="modal" data-target="#tambahPenilaian">
                                                            <i class="fa fa-edit"></i>
                                                        </button>

                                                        <form action="{{ url('penilaian/' . $data->id) }}"
                                                            class="d-inline" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="id_periode"
                                                                value="{{ $periode->id }}" />
                                                            <input type="hidden" name="id_kepala_sekolah"
                                                                value="{{ $data->id }}" />

                                                            <button type="submit" class="btn btn-sm btn-danger btn-delete">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="text-xs mt-3">
                                        <span class="ml-3">Keterangan :</span>
                                        <ul class="mt-1">
                                            @foreach ($kriteria as $kr)
                                                <li>
                                                    <b>C{{ $loop->iteration }}</b> : {{ $kr->nama_kriteria }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('js')
    <script>
        function tombolPeriode(id) {
            window.location.href = "{{ url('penilaian/') }}?id_periode=" + id;
        }

        function ubahkecamatan() {
            var id = $('#id_cari_kecamatan').val();
            var tampung = ``;

            $.get("{{ url('sekolah-per-kecamatan') }}/" + id, function(data) {
                if (data.length > 0) {
                    $.each(data, function(index, value) {
                        tampung += `<option value="` + value.id + `">` + value.nama_lengkap + ` |
                                                ` + value.nama_sekolah + `</option>`;
                    });
                } else {
                    tampung += `<option value="">Tidak ada sekolah</option>`;
                }
                $('#id_kepala_sekolah').html(tampung);
                $('#id_kepala_sekolah').removeAttr('disabled');
                $('.selectpicker').selectpicker('refresh');
            });
        }

        ubahkecamatan();

        function fungsiEdit(dt) {
            var dt = dt.split('|');

            var url = "{{ url('cek-penilaian') }}";

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id_kepala_sekolah: dt[0],
                    id_periode: dt[1]
                },
                success: function(data) {
                    $('#id_kepala_sekolah').val(dt[0]);

                    if (data.length > 0) {
                        $.each(data, function(index, value) {
                            console.log(value);
                            $('#kr' + value.id_kriteria).val(value.id_indikator);
                        });
                    }

                    $('.selectpicker').selectpicker('refresh');
                }
            });
        }

        @if (!empty(request('id_kecamatan')))
            $('select[name="id_kecamatan"]').val('{{ request('id_kecamatan') }}');
            $('.selectpicker').selectpicker('refresh');
        @endif
    </script>
@endsection
