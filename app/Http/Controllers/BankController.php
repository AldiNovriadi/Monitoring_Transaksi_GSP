<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\DataMitra;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    public function index()
    {
        $transactiontoday = Transaction::Valid()->whereDate('created_at', date('Y-m-d'))->where('bank_id', Bank::where('user_id', Auth::User()->id)->first()->kode_bank)->count();
        $transactionMonth = Transaction::Valid()->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->where('bank_id', Bank::where('user_id', Auth::User()->id)->first()->kode_bank)->count();
        $bank = Bank::with('transaction')->get();
        $bankmonth = Bank::with(['transaction' => function ($query) {
            $query->Valid()->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'));
        }])->get();

        $lastDay = date('d', strtotime(Carbon::now()->endOfMonth()->toDateString()));
        $pln = [];
        $non_pln = [];
        $tanggal = [];
        for ($i = 1; $i <= $lastDay; $i++) {
            $tanggal[] = $i;
            $pln[] = Transaction::Valid()->where('bank_id', Bank::where('user_id', Auth::User()->id)->first()->kode_bank)->whereMonth('tanggal', date('m'))->whereDay('tanggal', $i)->where(function ($query) {
                $query->where('produk_id', 99501)->orWhere('produk_id', 99504)->orWhere('produk_id', 99502);
            })->count();
            $non_pln[] = Transaction::Valid()->where('bank_id', Bank::where('user_id', Auth::User()->id)->first()->kode_bank)->whereMonth('tanggal', date('m'))->whereDay('tanggal', $i)->where(function ($query) {
                $query->where('produk_id', '!=', 99501)->where('produk_id', '!=', 99504)->where('produk_id', '!=', 99502);
            })->count();
        }

        return view('bank.index', ['bank' => $bank, 'bankmonth' => $bankmonth, 'transactiontoday' => $transactiontoday, 'transactionMonth' => $transactionMonth])
            ->with(['tanggal' => json_encode($tanggal, JSON_NUMERIC_CHECK), 'pln' => json_encode($pln, JSON_NUMERIC_CHECK), 'non_pln' => json_encode($non_pln, JSON_NUMERIC_CHECK)]);
    }

    public function transaksiini()
    {
        // $bank = Bank::where('kode_bank', $kode)->first();
        $bank = Bank::where('user_id', Auth::User()->id)->first();

        $trans = Transaction::Valid()->whereDate('created_at', date('Y-m-d'))->where('bank_id', $bank->kode_bank)->get();

        return view('bank.transaksiini', compact('trans', 'bank'));
    }

    public function transaksimonth()
    {
        $bank = Bank::where('user_id', Auth::User()->id)->first();
        $transaction = Transaction::Valid()->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->where('bank_id', $bank->kode_bank)->get();
        return view('bank.transaksimonth', compact('transaction'));
    }

    public function getMitra($id)
    {
        $bank = Bank::with('Mitra')->where('kode_bank', $id)->first();
        return response()->json(['mitra' => $bank->Mitra]);
    }
}
