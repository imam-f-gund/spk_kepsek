<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\Kecamatan;
use App\Models\KepalaSekolah;
use App\Models\Kriteria;
use App\Models\NilaiKepsek;
use App\Models\Normalisasi;
use App\Models\Periode;
use RealRashid\SweetAlert\Facades\Alert;

class RangkingKecamatanController extends Controller
{
    public function index()
    {
        // pertama kali di load
        $periode = Periode::get();
        $kecamatan = Kecamatan::get();

        return view('pages.rangking_kecamatan', compact('periode', 'kecamatan'));
    }

    public function cek()
    {
        $id_periode = request('id_periode');
        $id_kecamatan = request('id_kecamatan');

        $cek = KepalaSekolah::whereHas('nilai_kepsek', function ($query) use ($id_periode) {
            return $query->where('id_periode', $id_periode);
        })->whereHas('sekolah', function ($query) use ($id_kecamatan) {
            return $query->where('id_kecamatan', $id_kecamatan);
        })->whereHas('nilai_kepsek', function ($query) {
            return $query->whereNotNull('rangking');
        })->count();

        if ($cek > 0) {
            return response()->json([
                'status' => true,
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }

    public function hitung()
    {
        $id_periode = request('id_periode');
        $id_kecamatan = request('id_kecamatan');
        $trigger = request('trigger');

        $periode = Periode::get();
        $kecamatan = Kecamatan::get();

        if ($trigger == 0) {
            // perintah ambil data perhitungan dari database
            $cek = KepalaSekolah::whereHas('nilai_kepsek', function ($query) use ($id_periode) {
                return $query->where('id_periode', $id_periode);
            })->whereHas('sekolah', function ($query) use ($id_kecamatan) {
                return $query->where('id_kecamatan', $id_kecamatan);
            })->whereHas('nilai_kepsek', function ($query) use ($id_periode) {
                return $query->whereNotNull('rangking');
            })->count();

            // dia melakukan perhitungan pertama kali
            if ($cek <= 0) {
                // 1. normalisasi
                $this->normalisasi($id_periode, $id_kecamatan);
                // 2. perhitungan nilai saw
                $this->hitung_saw($id_periode, $id_kecamatan);
                // 3. perangkingan
                $this->rangking($id_periode, $id_kecamatan);
            }
        } else {
            $this->normalisasi($id_periode, $id_kecamatan);
            $this->hitung_saw($id_periode, $id_kecamatan);
            $this->rangking($id_periode, $id_kecamatan);
			
			Alert::success('Data berhasil dihitung ulang');
        }

        // menampilkan data hasil perangkingan
        $rangking = NilaiKepsek::where('id_periode', $id_periode)
            ->join('kepala_sekolah', 'kepala_sekolah.id', '=', 'nilai_kepsek.id_kepala_sekolah')
            ->join('sekolah', 'sekolah.id', '=', 'kepala_sekolah.id_sekolah')
            ->where('sekolah.id_kecamatan', $id_kecamatan)
            ->groupBy('nilai_kepsek.rangking')
            ->orderBy('nilai_kepsek.rangking', 'asc')
            ->select('nilai_kepsek.rangking', 'nilai_kepsek.nilai', 'kepala_sekolah.nama_lengkap', 'sekolah.nama_sekolah')
            ->get();


        return view('pages.rangking_kecamatan', compact('periode', 'kecamatan', 'rangking'));
    }

    private function normalisasi($id_periode, $id_kecamatan)
    {
       
        // mengambil data kepala sekolah per kecamatan
        $kepsek = KepalaSekolah::whereHas('nilai_kepsek', function ($query) use ($id_periode) {
            return $query->where('id_periode', $id_periode);
        })->whereHas('sekolah', function ($query) use ($id_kecamatan) {
            return $query->where('id_kecamatan', $id_kecamatan);
        })->get();

        $kepsek->each(function ($item) {
            $item->nilai_kepsek->each(function ($item) {
                // mengambil nilai max indikator
                $indikator = Indikator::find($item->id_indikator);
                $max = Indikator::where('id_kriteria', $indikator->id_kriteria)->max('nilai_indikator');

                // membagi nilai dari penilai dengan nilai max indikator
                $hitung_normalisasi = (float) $indikator->nilai_indikator / $max;
                $cek = Normalisasi::where('id_nilai_kepsek', $item->id)->first();

                if (empty($cek)) {
                    // nambahkan nilai normalisasi
                    $normalisasi = new Normalisasi;
                    $normalisasi->id_nilai_kepsek = $item->id;
                    $normalisasi->hasil_normalisasi = $hitung_normalisasi;
                    $normalisasi->save();
                } else {

                    // update nilai normalisasi
                    $cek->hasil_normalisasi = $hitung_normalisasi;
                    $cek->save();
                }
            });
        });
    }

    private function hitung_saw($id_periode, $id_kecamatan)
    {
        // ambil nilai bobot Kriteria
        $kriteria = Kriteria::get();

        // mengambil data kepala sekolah per kecamatan
        $kepsek = KepalaSekolah::whereHas('nilai_kepsek', function ($query) use ($id_periode) {
            return $query->where('id_periode', $id_periode);
        })->whereHas('sekolah', function ($query) use ($id_kecamatan) {
            return $query->where('id_kecamatan', $id_kecamatan);
        })->get();

        foreach ($kepsek as $ks) {

            $nilai = (float) 0;

            // 12 kali perualangan (12 kriteria)
            foreach ($kriteria as $kr) {
                // mengubah nilai bobot menjadi prersentase 0-1
                $bobot = (float) $kr->bobot_kriteria / 100;

                // mengambil nilai normalisasi per kepala sekolah
                $nilaikepsek = NilaiKepsek::join('indikator', 'nilai_kepsek.id_indikator', '=', 'indikator.id')
                    ->join('normalisasi', 'nilai_kepsek.id', '=', 'normalisasi.id_nilai_kepsek')
                    ->where('nilai_kepsek.id_kepala_sekolah', $ks->id)
                    ->where('indikator.id_kriteria', $kr->id)
                    ->where('nilai_kepsek.id_periode', $id_periode)
                    ->first();

                // perhitungan saw | hasil normalisai * bobot ($nilaikepsek->hasil_normalisasi * $bobot)
                // 0 + 0.33 + 0.12 + ...
                $nilai = (float) $nilai + ($nilaikepsek->hasil_normalisasi * $bobot);
            }

            // total nilai saw disimpan
            NilaiKepsek::where('id_kepala_sekolah', $ks->id)
                ->where('id_periode', $id_periode)
                ->update([
                    'nilai' => $nilai,
                ]);
        }
    }

    private function rangking($id_periode, $id_kecamatan)
    {
        // nilai kepsek yang sudah ada totalnya
        $nilai = NilaiKepsek::join('kepala_sekolah', 'nilai_kepsek.id_kepala_sekolah', '=', 'kepala_sekolah.id')
            ->join('sekolah', 'kepala_sekolah.id_sekolah', '=', 'sekolah.id')
            ->where('nilai_kepsek.id_periode', $id_periode)
            ->where('sekolah.id_kecamatan', $id_kecamatan)
            ->groupBy('nilai_kepsek.id_kepala_sekolah')
        // diurutkan berdasarkan nilai terbesar
            ->orderBy('nilai_kepsek.nilai', 'desc')
            ->select('nilai_kepsek.id')
            ->get();

        $no = 1;

        foreach ($nilai as $n) {
            $nilai = NilaiKepsek::find($n->id);

            // update kolom rangking
            NilaiKepsek::where('id_kepala_sekolah', $nilai->id_kepala_sekolah)
                ->where('id_periode', $id_periode)
                ->update([
                    'rangking' => $no,
                ]);

            $no++;
        }
    }

}
