<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\DataMitra;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    public function index()
    {
        $transactiontoday = Transaction::where('tanggal', date('Y-m-d'))->where('bank_id',Bank::where('user_id',Auth::User()->id)->first()->kode_bank)->count();
        $transactionMonth = Transaction::whereMonth('tanggal', date('m'))->whereYear('tanggal',date('Y'))->where('bank_id',Bank::where('user_id',Auth::User()->id)->first()->kode_bank)->count();
        $bank = Bank::with('transaction')->get();
        $bankmonth = Bank::with(['transaction' => function ($query) {
            $query->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'));
        }])->get();

        return view('bank.index', ['bank' => $bank, 'bankmonth' => $bankmonth, 'transactiontoday' => $transactiontoday,'transactionMonth'=>$transactionMonth]);
    }

    public function transaksiini()
    {
        // $bank = Bank::where('kode_bank', $kode)->first();
        $bank = Bank::where('user_id',Auth::User()->id)->first();

        $trans = Transaction::where('tanggal', date('Y-m-d'))->where('bank_id', $bank->kode_bank)->get();

        return view('bank.transaksiini', compact('trans', 'bank'));
    }

    public function transaksimonth()
    {
        $transaction = Transaction::where('tanggal', date('Y-m-d'))->get();
        return view('bank.transaksimonth', compact('transaction'));
    }
}
