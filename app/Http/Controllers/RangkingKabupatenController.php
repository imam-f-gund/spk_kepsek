<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\NilaiKepsek;
use App\Models\Periode;

class RangkingKabupatenController extends Controller
{
    public function index()
    {
        $periode = Periode::get();

        return view('pages.rangking_kabupaten', compact('periode'));
    }

    public function hitung()
    {
        // perintah ambil periode
        $id_periode = request('id_periode');

        $kecamatan = Kecamatan::get();

        $data = array();

        foreach ($kecamatan as $kec) {
            $nilai = NilaiKepsek::where('id_periode', $id_periode)
                ->join('kepala_sekolah', 'kepala_sekolah.id', '=', 'nilai_kepsek.id_kepala_sekolah')
                ->join('sekolah', 'sekolah.id', '=', 'kepala_sekolah.id_sekolah')
                ->where('sekolah.id_kecamatan', $kec->id)
                ->groupBy('nilai_kepsek.rangking')
                ->orderBy('nilai_kepsek.rangking', 'asc')
                ->select('nilai_kepsek.id_kepala_sekolah as id_kepala_sekolah')
				// ambil 3 data per kecamatan
                ->limit('3')->get();

            foreach ($nilai as $n) {
                $data[] = $n->id_kepala_sekolah;
            }
        }

		// proses perangkingan per kabupaten
        $rangking = NilaiKepsek::where('id_periode', $id_periode)
            ->join('kepala_sekolah', 'kepala_sekolah.id', '=', 'nilai_kepsek.id_kepala_sekolah')
            ->join('sekolah', 'sekolah.id', '=', 'kepala_sekolah.id_sekolah')
            ->join('kecamatan', 'kecamatan.id', '=', 'sekolah.id_kecamatan')
            ->whereNotNull('nilai_kepsek.rangking')
            ->groupBy('nilai_kepsek.id_kepala_sekolah')
            ->orderBy('nilai_kepsek.nilai', 'DESC')
            ->select('nilai_kepsek.rangking', 'nilai_kepsek.nilai', 'kepala_sekolah.nama_lengkap', 'sekolah.nama_sekolah', 'kecamatan.nama_kecamatan')
            ->whereIn('nilai_kepsek.id_kepala_sekolah', $data)
            ->get();

        $periode = Periode::get();

        return view('pages.rangking_kabupaten', compact('periode', 'rangking'));
    }
}
