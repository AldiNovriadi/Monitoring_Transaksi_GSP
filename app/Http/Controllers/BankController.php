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
        $transactiontoday = Transaction::where('tanggal', date('Y-m-d'))->count();
        $bank = Bank::with('transaction')->get();
        $bankmonth = Bank::with(['transaction' => function ($query) {
            $query->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'));
        }])->get();

        return view('bank.index', ['bank' => $bank, 'bankmonth' => $bankmonth, 'transactiontoday' => $transactiontoday]);
    }

    public function transaksiini()
    {
        // $bank = Bank::where('kode_bank', $kode)->first();
        $akun = DataMitra::with('bank')->find(Auth::user()->mitra_id);

        $trans = Transaction::where('tanggal', date('Y-m-d'))->where('bank_id', $akun->bank->kode_bank)->get();

        return view('bank.transaksiini', compact('trans', 'akun'));
    }

    public function transaksimonth()
    {
        $transaction = Transaction::where('tanggal', date('Y-m-d'))->get();
        return view('bank.transaksimonth', compact('transaction'));
    }
}
