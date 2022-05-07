<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class KelolabankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank = Bank::all();
        return view('kelolabank.index', ['bank' => $bank]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kelolabank.create');
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
            'kode_bank' => 'required',
            'nama_bank' => 'required',
            'filetemplate'=>'mimes:xlsx, csv, xls'
        ]);

        if($request->hasFile('filtetemplate')){
            $file = $request->file('filtetemplate');
            $file->move(public_path('/excelTemplate'),$file->getClientOriginalName());
            $request['filetemplate'] = $file->getClientOriginalName();
        }
       
        Bank::create($request->all());
        toast('Data bank berhasil dibuat', 'success');
        return redirect('/kelolabank');
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
        $bank = Bank::find($id);
        return view('kelolabank.edit', ['bank' => $bank]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank, $id)
    {
        $request->validate([
            'kode_bank' => 'required',
            'nama_bank' => 'required',
            'filetemplate'=>'mimes:xlsx, csv, xls'
        ]);
        $bank = bank::find($id);
        if($request->hasFile('filtetemplate')){
            if(!empty($bank->filetemplate)){
                unlink(public_path('/excelTemplate/'.$bank->filetemplate));
            }
            $file = $request->file('filtetemplate');
            $bank->filetemplate = $file->getClientOriginalName();
            $file->move(public_path('/excelTemplate'),$file->getClientOriginalName());
        }
        $bank->kode_bank = $request->kode_bank;
        $bank->nama_bank = $request->nama_bank;
        $bank->save();

        $bank->update($request->all());
        toast('Data bank diupdate', 'success');
        return redirect('/kelolabank');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $kelolabank)
    {
        $kelolabank->load('user');
        if(!empty($kelolabank->user)){
            $kelolabank->user->delete();
        }
  
        $kelolabank->delete();
        toast('Data Bank berhasil dihapus', 'success');
        return redirect('/kelolabank');
    }
}
