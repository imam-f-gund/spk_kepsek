<?php

namespace App\Http\Controllers;

use App\Models\KepalaSekolah;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KepalaSekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kepsek = KepalaSekolah::orderBy('id', 'DESC')->get();
        $sekolah = Sekolah::get();

        return view('pages.kepsek', compact('kepsek', 'sekolah'));
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
            'nama_lengkap' => 'required',
            'id_sekolah' => 'required',
        ]);

        $kepsek = new KepalaSekolah;
        $kepsek->nama_lengkap = $request->nama_lengkap;
        $kepsek->id_sekolah = $request->id_sekolah;
        $kepsek->alamat = $request->alamat;
        $kepsek->no_telp = $request->no_telp;
        $kepsek->save();

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
            'nama_lengkap' => 'required',
            'id_sekolah' => 'required',
        ]);

        $kepsek = KepalaSekolah::findOrFail($id);
        $kepsek->nama_lengkap = $request->nama_lengkap;
        $kepsek->id_sekolah = $request->id_sekolah;
        $kepsek->alamat = $request->alamat;
        $kepsek->no_telp = $request->no_telp;
        $kepsek->save();

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
        $kepsek = KepalaSekolah::findOrFail($id);
        $kepsek->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus');
        return back();
    }
}
