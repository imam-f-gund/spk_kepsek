<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\Kecamatan;
use App\Models\KepalaSekolah;
use App\Models\Kriteria;
use App\Models\NilaiKepsek;
use App\Models\Periode;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kepsek = KepalaSekolah::all();
        $kriteria = Kriteria::all();
        $kecamatan = Kecamatan::all();

        if (empty(request('id_periode'))) {
            $periode = Periode::orderBy('id', 'desc')->get();
            $nilai = NilaiKepsek::get();
        } else {
            $periode = Periode::find(request('id_periode'));
            $nilai = KepalaSekolah::whereHas('nilai_kepsek', function ($query) {
                return $query->where('id_periode', request('id_periode'));
            })->get();

            if (!empty(request('id_kecamatan'))) {
                $nilai = KepalaSekolah::whereHas('nilai_kepsek', function ($query) {
                    return $query->where('id_periode', request('id_periode'));
                })->whereHas('sekolah', function ($query) {
                    return $query->where('id_kecamatan', request('id_kecamatan'));
                })->get();
            }

        }
        return view('pages.penilaian', compact('nilai', 'periode', 'kepsek', 'kriteria', 'kecamatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'id_periode' => 'required',
            'id_kepala_sekolah' => 'required',
            'id_indikator' => 'required',
        ]);

        foreach ($request->id_indikator as $value) {
            $indikator = Indikator::find($value);
            $cek = NilaiKepsek::join('indikator', 'indikator.id', '=', 'nilai_kepsek.id_indikator')
                ->where('nilai_kepsek.id_periode', $request->id_periode)
                ->where('nilai_kepsek.id_kepala_sekolah', $request->id_kepala_sekolah)
                ->where('indikator.id_kriteria', $indikator->id_kriteria)
                ->select('nilai_kepsek.*')
                ->first();

            if (empty($cek)) {
                $nilai = new NilaiKepsek;
                $nilai->id_periode = $request->id_periode;
                $nilai->id_kepala_sekolah = $request->id_kepala_sekolah;
                $nilai->id_indikator = $value;
                $nilai->save();
            } else {
                $nilai = NilaiKepsek::find($cek->id);
                $nilai->id_indikator = $value;
                $nilai->save();
            }
        }

        Alert::success('Berhasil', 'Data Berhasil Disimpan');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        NilaiKepsek::where('id_periode', request('id_periode'))->where('id_kepala_sekolah', request('id_kepala_sekolah'))->delete();
        Alert::success('Berhasil', 'Data Berhasil Dihapus');

        return back();
    }

    public function cek_penilaian()
    {
        $data = NilaiKepsek::join('indikator', 'indikator.id', 'nilai_kepsek.id_indikator')
            ->where('id_periode', request('id_periode'))
            ->where('id_kepala_sekolah', request('id_kepala_sekolah'))
            ->join('kriteria', 'kriteria.id', 'indikator.id_kriteria')
            ->select('nilai_kepsek.id_indikator as id_indikator', 'kriteria.id as id_kriteria')
            ->get();

        return response()->json($data);
    }

    public function getKepsekByKecamatan($id)
    {
        $kepsek = KepalaSekolah::join('sekolah', 'sekolah.id', 'kepala_sekolah.id_sekolah')
            ->where('sekolah.id_kecamatan', $id)
            ->select('kepala_sekolah.*', 'sekolah.nama_sekolah')
            ->get();

        return response()->json($kepsek);
    }
}
