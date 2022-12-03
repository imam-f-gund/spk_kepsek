@extends('layouts.app')

@section('title', 'Perangkingan Tingkat Kecamatan')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row mb-3 justify-content-center">
            <div class="col text-center">
                <h1 class="h3 mb-2 text-gray-800">Perangkingan Tingkat Kecamatan</h1>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="{{ url('hitung-kecamatan') }}">
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
                                <label>Pilih Kecamatan</label>
                                <select class="form-control selectpicker" data-live-search="true" id="id_kecamatan"
                                    name="id_kecamatan">
                                    @foreach ($kecamatan as $kec)
                                        <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @csrf
                            <input type="hidden" name="trigger" value="">

                            <button onclick="fungsiHitung()" class="btn btn-primary mt-3" type="submit">Lihat
                                Perangkingan</button>
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
                                    <td>{{ $rk->nama_sekolah }}</td>
                                    <td>{{ $rk->nama_lengkap }}</td>
                                    <td>{{ $rk->nilai }}</td>
                                    <td>{{ $rk->rangking }}</td>
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

@section('js')
    <script>
        function fungsiHitung() {
            event.preventDefault(); // prevent form submit
            var form = event.target.form; // storing the form

            $.ajax({
                url: "{{ url('cek-perhitungan-kecamatan') }}",
                type: "GET",
                data: {
                    id_periode: $('#id_periode').val(),
                    id_kecamatan: $('#id_kecamatan').val()
                },
                success: function(result) {
                    console.log(result);
                    if (result.status) {
                        Swal.fire({
                            title: 'Apakah ingin hitung ulang ?',
                            text: "Data sudah pernah dihitung",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: "Ya",
                            cancelButtonText: "Tidak",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        }).then((result) => {
                            if (result.value) {
                                $('input[name=trigger]').val(1);
                            } else {
                                $('input[name=trigger]').val(0);
                            }
                            form.submit();
                        });

                    } else {
                        $('input[name=trigger]').val(0);
                        form.submit();
                    }
                }
            });

        }
    </script>
@endsection
