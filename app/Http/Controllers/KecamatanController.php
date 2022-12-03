<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kecamatan = Kecamatan::orderBy('id', 'DESC')->get();

        return view('pages.kecamatan', compact('kecamatan'));
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
            'nama_kecamatan' => 'required',
        ]);

        $kecamatan = new Kecamatan;
        $kecamatan->nama_kecamatan = $request->nama_kecamatan;
        $kecamatan->save();

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
            'nama_kecamatan' => 'required',
        ]);

        $kecamatan = Kecamatan::find($id);
        $kecamatan->nama_kecamatan = $request->nama_kecamatan;
        $kecamatan->save();

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
        $kecamatan = Kecamatan::find($id);
        $kecamatan->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus');
        return back();
    }
}
