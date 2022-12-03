<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\NilaiKepsek;
use App\Models\Periode;
use Barryvdh\DomPDF\Facade as PDF;

class LaporanController extends Controller
{
    public function kecamatan()
    {
        $periode = Periode::get();
        $kecamatan = Kecamatan::get();

        return view('pages.laporan_kecamatan', compact('periode', 'kecamatan'));
    }

    public function kabupaten()
    {
        $periode = Periode::get();

        return view('pages.laporan_kabupaten', compact('periode'));
    }

    public function laporan_kecamatan()
    {
        $id_periode = request('id_periode');
        $id_kecamatan = request('id_kecamatan');

        $periode = Periode::find($id_periode);
        $kecamatan = Kecamatan::find($id_kecamatan);

        $rangking = NilaiKepsek::where('id_periode', $id_periode)
            ->join('kepala_sekolah', 'kepala_sekolah.id', '=', 'nilai_kepsek.id_kepala_sekolah')
            ->join('sekolah', 'sekolah.id', '=', 'kepala_sekolah.id_sekolah')
            ->join('kecamatan', 'kecamatan.id', '=', 'sekolah.id_kecamatan')
            ->where('kecamatan.id', $id_kecamatan)
            ->whereNotNull('nilai_kepsek.rangking')
            ->groupBy('nilai_kepsek.id_kepala_sekolah')
            ->orderBy('nilai_kepsek.nilai', 'DESC')
            ->select('nilai_kepsek.rangking', 'nilai_kepsek.nilai', 'kepala_sekolah.nama_lengkap', 'sekolah.nama_sekolah', 'kecamatan.nama_kecamatan')
            ->get();

        $pdf = PDF::loadview('laporan.kecamatan', compact('rangking', 'periode', 'kecamatan'));
        return $pdf->download('laporan_kecamatan_' . \str($kecamatan->nama_kecamatan . ' ' . $periode->nama_periode)->slug('_') . '.pdf');
    }

    public function laporan_kabupaten()
    {
        $id_periode = request('id_periode');
        $periode = Periode::find($id_periode);

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

        $pdf = PDF::loadview('laporan.kabupaten', compact('rangking', 'periode'));
        return $pdf->download('laporan_kabupaten_' . \str($periode->nama_periode)->slug('_') . '.pdf');
    }
}
