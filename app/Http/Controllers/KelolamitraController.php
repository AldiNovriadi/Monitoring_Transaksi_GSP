<?php

namespace App\Http\Controllers;

use App\Models\Cid;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Middleware\Mitra;

class KelolamitraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mitra = Cid::with('Bank')->get();
        return view('kelolamitra.index', compact('mitra'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bank = Bank::all();
        return view('kelolamitra.create', compact('bank'));
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
            'kode_cid' => 'required',
            'nama_cid' => 'required',
            'bank_id' => 'required',
            'filetemplate'=>'mimes:xlsx, csv, xls'
        ]);

        $bank_id = Bank::where('kode_bank',$request->bank_id)->first();
        $request['bank_id'] = $bank_id->id;

        if($request->hasFile('filtetemplate')){
            $file = $request->file('filtetemplate');
            $file->move(public_path('/excelTemplate'),$file->getClientOriginalName());
            $request['filetemplate'] = $file->getClientOriginalName();
        }

        if(empty($request->is_aggregator)){
            $request['jenis'] = 'NonAggregator';
        }else{
            $request['jenis'] = 'Aggregator';
        }

        Cid::create($request->all());
        toast('Data mitra berhasil dibuat', 'success');
        return redirect('/kelolamitra');
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
    public function edit(Cid $kelolamitra)
    {
        $bank = Bank::all();
        $mitra = $kelolamitra;
        return view('kelolamitra.edit',compact('mitra','bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cid $kelolamitra)
    {
        $mitra = Cid::find($kelolamitra->id);
        $request->validate([
            'kode_cid' => 'required',
            'nama_cid' => 'required',
            'bank_id' => 'required',
            'filetemplate'=>'mimes:xlsx, csv, xls'
        ]);

        if($request->hasFile('filtetemplate')){
            if(!empty($mitra->filetemplate)){
                unlink(public_path('/excelTemplate/'.$mitra->filetemplate));
            }
            $file = $request->file('filtetemplate');
            $mitra->filetemplate = $file->getClientOriginalName();
            $file->move(public_path('/excelTemplate'),$file->getClientOriginalName());
        }
        $mitra->kode_cid = $request->kode_cid;
        $mitra->nama_cid = $request->nama_cid;
        $mitra->bank_id = $request->bank_id;

        $mitra->save();
        toast('Data mitra berhasil diupdate', 'success');
        return redirect('/kelolamitra');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cid $kelolamitra)
    {
        $kelolamitra->load('user');
        if(!empty($kelolamitra->user)){
            $kelolamitra->user->delete();
        }

        $kelolamitra->delete();
        toast('Data Mitra berhasil dihapus', 'success');
        return back();
    }
}
