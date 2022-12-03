<!DOCTYPE html>
<html>

<head>
    <title>Report Kecamatan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 8pt;
            white-space: nowrap;
        }

    </style>
    <center>
        <h5>Laporan Rangking Penilaian Kepala Sekolah Tingkat Kecamatan</h5>
        <h6>{{ $periode->nama_periode }} Kecamatan {{ $kecamatan->nama_kecamatan }}</h6>
    </center>

    <table class="table mt-4 table-bordered table-striped">
        <thead>
            <tr class="text-center bg-success text-white">
                <th width="3%">No</th>
                <th>Nama Sekolah</th>
                <th>Nama Kepsek</th>
                <th width="10%">Nilai</th>
                <th width="10%">Rangking</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rangking as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->nama_sekolah }}</td>
                    <td>{{ $p->nama_lengkap }}</td>
                    <td>{{ $p->nilai }}</td>
                    <td>{{ $loop->iteration }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
