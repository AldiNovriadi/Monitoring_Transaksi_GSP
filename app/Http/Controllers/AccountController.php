<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\DataMitra;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account = DataMitra::all();
        return view('account.index', ['account' => $account]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bank = Bank::where('status', 0)->get();

        return view('account.create', compact('bank'));
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
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'bank_id' => 'required'
        ]);

        $bank = Bank::where('id', $request->bank_id)->first();
        $bank->update([
            'status' => 1
        ]);

        DataMitra::create($request->all());
        toast('Akun berhasil dibuat', 'success');
        return redirect('/account');
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
        $bank = Bank::all();
        $account = DataMitra::find($id);
        return view('account.edit', compact('account', 'bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DataMitra $account)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'status' => 'required'
        ]);

        $account->update($request->all());
        toast('Akun berhasil diupdate', 'success');
        return redirect('/account');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataMitra $account)
    {
        $account->delete();
        toast('Akun berhasil dibuat', 'success');
        return redirect('/account');
    }
}
