<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $bank = Bank::with('transaction')->get();
        $bankmonth = Bank::with(['transaction' => function ($query) {
            $query->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'));
        }])->get();

        return view('bank.index', ['bank' => $bank, 'bankmonth' => $bankmonth]);
    }

    public function mitra()
    {
        return view('mitra.index');
    }
}
