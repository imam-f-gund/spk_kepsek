<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periode = Periode::get();

        return view('pages.periode', compact('periode'));
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
            'nama_periode' => 'required',
            'tahun' => 'required',
        ]);

        $periode = new Periode;
        $periode->nama_periode = $request->nama_periode;
        $periode->tahun = $request->tahun . '-01-01';
        $periode->save();

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
            'nama_periode' => 'required',
            'tahun' => 'required',
        ]);

        $periode = Periode::findOrFail($id);
        $periode->nama_periode = $request->nama_periode;
        $periode->tahun = $request->tahun . '-01-01';
        $periode->save();

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
        $periode = Periode::findOrFail($id);
        $periode->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus');
        return back();
    }
}
