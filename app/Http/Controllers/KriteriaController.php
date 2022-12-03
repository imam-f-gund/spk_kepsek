<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kriteria = Kriteria::get();

        return view('pages.kriteria', compact('kriteria'));
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
            'nama_kriteria' => 'required',
            'bobot_kriteria' => 'numeric',
        ]);

        $kriteria = new Kriteria;
        $kriteria->nama_kriteria = $request->nama_kriteria;
        $kriteria->bobot_kriteria = $request->bobot_kriteria;
        $kriteria->save();

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
        request()->validate([
            'nama_kriteria' => 'required',
            'bobot_kriteria' => 'numeric',
        ]);

        $kriteria = Kriteria::find($id);
        $kriteria->nama_kriteria = $request->nama_kriteria;
        $kriteria->bobot_kriteria = $request->bobot_kriteria;
        $kriteria->save();

        Alert::success('Berhasil', 'Data Berhasil Diubah');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kriteria = Kriteria::find($id);

        Indikator::where('id_kriteria', $id)->delete();

        $kriteria->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus');
        return back();
    }

    public function cek_kriteria()
    {
        $kriteria = Indikator::where('id_kriteria', request('id'))->get();

        return response()->json($kriteria);
    }
}
