<?php

namespace App\Http\Controllers;

use App\Models\tabungan;
use Illuminate\Http\Request;

class TabunganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $title = 'Tabungan';
        // $description = 'Some description for the page';
        $tabungan = tabungan::all();
        // $tabungans = tabungan::findorfail($id);
        return view('tabungan.index', compact('tabungan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required',
            'jumlah_tabungan' => 'required',
            'foto' => 'required'
        ]);
        $tabungan = new tabungan();

        $tabungan->nama_barang = $request->nama_barang;
        $tabungan->jumlah_tabungan = $request->jumlah_tabungan;
        $tabungan->nominal = $request->nominal;
        if ($request->hasFile('foto')) {
            $img = $request->file('foto');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move('images/tabungan/', $name);
            $tabungan->foto = $name;
        }
        $tabungan->save();

        return redirect()->back();
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
        // $tabungan = tabungan::findOrFail($id);
        // return view('pages.dashboard.tabunganedit', compact('tabungan'));
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
        $tabungan = tabungan::findorfail($id);

        $tabungan->nama_barang = $request->nama_barang;
        $tabungan->jumlah_tabungan = $request->jumlah_tabungan;
        $tabungan->nominal = $request->nominal;
        if ($request->hasFile('foto')) {
            $img = $request->file('foto');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move('images/tabungan/', $name);
            $tabungan->foto = $name;
        }
        $tabungan->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tabungan = tabungan::findOrFail($id);
        $tabungan->deleteImage();
        $tabungan->delete();
        // $tabungan->genre()->detach();
        return redirect()->route('tabungan.index')
            ->with('success', 'data berhasil dihapus');
    }
}
