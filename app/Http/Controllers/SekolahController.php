<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sekolah = Sekolah::orderBy('id', 'DESC')->get();
        $kecamatan = Kecamatan::get();

        return view('pages.sekolah', compact('sekolah', 'kecamatan'));
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
            'nama_sekolah' => 'required',
            'id_kecamatan' => 'required',
        ]);

        $sekolah = new Sekolah;
        $sekolah->nama_sekolah = $request->nama_sekolah;
        $sekolah->id_kecamatan = $request->id_kecamatan;
        $sekolah->save();

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
            'nama_sekolah' => 'required',
            'id_kecamatan' => 'required',
        ]);

        $sekolah = Sekolah::findOrFail($id);
        $sekolah->nama_sekolah = $request->nama_sekolah;
        $sekolah->id_kecamatan = $request->id_kecamatan;
        $sekolah->save();

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
        $sekolah = Sekolah::findOrFail($id);
        $sekolah->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus');

        return back();
    }
}
