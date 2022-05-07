<?php

namespace App\Http\Controllers;

use App\Models\Cid;
use App\Models\Bank;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MitraController extends Controller
{
    public function index()
    {
        $transactiontoday = Transaction::where('tanggal', date('Y-m-d'))->where('cid_id',Cid::where('user_id',Auth::User()->id)->first()->kode_cid)->count();
        $transactionMonth = Transaction::whereMonth('tanggal', date('m'))->whereYear('tanggal',date('Y'))->where('cid_id',Cid::where('user_id',Auth::User()->id)->first()->kode_cid)->count();
        return view('mitra.index',compact('transactiontoday','transactionMonth'));
    }

    public function transaksiini()
    {
        $transactions =  Transaction::with('cid','produk','bank','kd')->where('tanggal', date('Y-m-d'))->where('cid_id',Cid::where('user_id',Auth::User()->id)->first()->kode_cid)->get();
        return view('mitra.transaksiini',compact('transactions'));
    }

    public function transaksimonth()
    {
        $transactions =  Transaction::with('cid','produk','bank','kd')->whereMonth('tanggal', date('m'))->whereYear('tanggal',date('Y'))->where('cid_id',Cid::where('user_id',Auth::User()->id)->first()->kode_cid)->get();
        return view('mitra.transaksimonth',compact('transactions'));
    }
}
