<?php

namespace App\Http\Controllers;

use App\Models\Billers;
use Illuminate\Http\Request;

class KelolabillerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $biller = Billers::all();
        return view('kelolabiller.index', ['biller' => $biller]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kelolabiller.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_biller' => 'required',
            'nama_biller' => 'required',
        ]);

        Billers::create($request->all());
        toast('Data biller berhasil dibuat', 'success');
        return redirect('/kelolabiller');
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
        $biller = Billers::find($id);
        return view('kelolabiller.edit', compact('biller'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Billers $biller, $id)
    {
        $biller = Billers::find($id);
        $biller->kode_biller = $request->kode_biller;
        $biller->nama_biller = $request->nama_biller;
        $biller->save();

        $biller->update($request->all());
        toast('Akun berhasil diupdate', 'success');
        return redirect('/kelolabiller');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Billers $biller, $id)
    {
        $biller = Billers::find($id);

        $biller->delete();
        toast('Data biller berhasil dihapus', 'success');
        return redirect('/kelolabiller');
    }
}
