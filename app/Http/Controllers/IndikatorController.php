<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class IndikatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $id_kriteria = $request->nama_kriteria;

        $nama = array();

        foreach ($request->nama_indikator as $key => $value) {

            $cek = Indikator::where('id_kriteria', $id_kriteria)->where('nama_indikator', $value)->first();

            array_push($nama, $value);

            if (empty($cek)) {
                $indikator = new Indikator;
                $indikator->id_kriteria = $id_kriteria;
                $indikator->nama_indikator = $value;
                $indikator->nilai_indikator = $request->nilai_indikator[$key];
                $indikator->save();
            } else {
                $indikator = Indikator::where('id_kriteria', $id_kriteria)->where('nama_indikator', $value)->first();
                $indikator->nilai_indikator = $request->nilai_indikator[$key];
                $indikator->save();
            }
        }

        Indikator::where('id_kriteria', $id_kriteria)->whereNotIn('nama_indikator', $nama)->delete();

        Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
