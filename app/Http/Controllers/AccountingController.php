<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function index()
    {
        $transactiontoday = Transaction::where('tanggal', date('Y-m-d'))->count();
        $transactionmount = Transaction::whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->count();

        return view('accounting.index', compact('transactiontoday', 'transactionmount'));
    }

    public function transaksi()
    {
        $transaction = Transaction::where('tanggal', date('Y-m-d'))->get();
        return view('accounting.transaksi', compact('transaction'));
    }

    public function detailtransaksi()
    {
        $transaction = Transaction::where('tanggal', date('Y-m-d'))->get();
        return view('accounting.detailtransaksi', compact('transaction'));
    }

    public function laporan()
    {
        return view('accounting.laporan');
    }
}
