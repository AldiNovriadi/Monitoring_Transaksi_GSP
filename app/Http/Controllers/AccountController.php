<?php

namespace App\Http\Controllers;

use App\Models\Cid;
use App\Models\Bank;
use App\Models\User;
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
        $account = User::all();
        return view('account.index', ['account' => $account]); // normal na kie

    }

    /**
     * Show the form for creating a new resource.
     *  
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banks = Bank::whereNull('user_id')->get();
        $mitras = Cid::whereNull('user_id')->get();

        return view('account.create', compact('banks','mitras'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $is_aktif = 0;
        $password = null;
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);

        if($request->role == 'Admin' || $request->role == 'Accounting'){
            $is_aktif = 1;
            $password = bcrypt('password');
        }

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'role'=>$request->role,
            'is_aktif'=>$is_aktif,
            'password'=>$password,
        ]);

        if($request->role == 'Bank'){
            $bank = Bank::where('id', $request->bank_id)->first();
            $bank->update([
                'user_id'=>$user->id
            ]);
        }

        else if($request->role == 'Mitra'){
        
            $mitra = Cid::where('id',$request->mitra_id)->first();
            $mitra->update([
                'user_id'=>$user->id,
            ]);
        }

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
        $account = User::find($id);
        return view('account.edit', compact('account', 'bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $account)
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
    public function destroy(User $account)
    {   
        if($account->role == 'Bank'){
            $bank = Bank::where('user_id',$account->id)->first();
            $bank->update([
                'user_id'=>null,
            ]);
        }

        else if($account->role == 'Mitra'){
            $mitra = Cid::where('user_id',$account->id)->first();
            $mitra->update([
                'user_id'=>null,
            ]);
        }
        $account->delete();
        toast('Akun berhasil dibuat', 'success');
        return redirect('/account');
    }

    public function resetPassword(User $id){
        $id->update([
            'password'=>bcrypt('password'),
            'is_forget_password'=>0
        ]);
        toast('Password akun berhasil direset','success');
        return back();
    }
}
