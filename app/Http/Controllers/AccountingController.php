<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cid;
use App\Models\Bank;
use App\Models\Produk;
use App\Models\Billers;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AccountingController extends Controller
{
    public function index()
    {
        $transaction = Transaction::where('tanggal', date('Y-m-d'))->get();
        $transactiontoday = Transaction::where('tanggal', date('Y-m-d'))->count();
        $transactionmount = Transaction::whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->count();

        $lastDay = date('d', strtotime(Carbon::now()->endOfMonth()->toDateString()));
        $pln = [];
        $non_pln = [];
        $tanggal = [];
        for ($i = 1; $i <= $lastDay; $i++) {
            $tanggal[] = $i;
            $pln[] = Transaction::whereMonth('tanggal', date('m'))->whereDay('tanggal', $i)->where(function ($query) {
                $query->where('produk_id', 99501)->orWhere('produk_id', 99504)->orWhere('produk_id', 99502);
            })->count();
            $non_pln[] = Transaction::whereMonth('tanggal', date('m'))->whereDay('tanggal', $i)->where(function ($query) {
                $query->where('produk_id', '!=', 99501)->where('produk_id', '!=', 99504)->where('produk_id', '!=', 99502);
            })->count();
        }

        return view('accounting.index', ['transaction' => $transaction, 'transactiontoday' => $transactiontoday, 'transactionmount' => $transactionmount])
            ->with(['tanggal' => json_encode($tanggal, JSON_NUMERIC_CHECK), 'pln' => json_encode($pln, JSON_NUMERIC_CHECK), 'non_pln' => json_encode($non_pln, JSON_NUMERIC_CHECK)]);
    }

    public function transaksi()
    {
        $transaction = DB::table('transaction')->select('produk_id', 'tanggal', 'cid_id', DB::raw('sum(bulan) as lembar'), DB::raw('sum(rptag) as tagihan'))->where('tanggal', date('Y-m-d'))->groupBy('cid_id', 'produk_id', 'tanggal')->get();
        // $transaction = Transaction::where('tanggal', date('Y-m-d'))->get();

        return view('accounting.transaksi', compact('transaction'));
    }

    public function detailtransaksi()
    {
        // $transaction = Transaction::where('tanggal', date('Y-m-d'))->get();
        $transaction = DB::table('transaction')->select('tanggal', 'cid_id', DB::raw('sum(bulan) as lembar'), DB::raw('sum(rptag) as tagihan'))->where('tanggal', date('Y-m-d'))->groupBy('cid_id', 'tanggal')->get();

        return view('accounting.detailtransaksi', compact('transaction'));
    }

    public function laporan()
    {
        return view('accounting.laporan');
    }

    public function filter(Request $request)
    {
        $bank = Bank::all()->sortBy('nama_bank');
        $mitra = Cid::all()->sortBy('nama_cid');
        $produk = Produk::all()->sortBy('nama_produk');

        if (count($request->all()) > 0) {
            $transaction = Transaction::all();
            if (!empty($request->tanggalawal)) {
                if (empty($request->tanggalakhir)) {
                    $request['tanggalakhir'] = $request->tanggalawal;
                }
                $transaction = $transaction->where('tanggal', '>=', date('Y-m-d', strtotime($request->tanggalawal)))->where('tanggal', '<=', date('Y-m-d', strtotime($request->tanggalakhir)));
            }

            if (!empty($request->bank)) {
                $transaction = $transaction->where('bank_id', $request->bank);
            }

            if (!empty($request->mitra)) {
                $transaction = $transaction->where('cid_id', $request->mitra);
            }

            if (!empty($request->produk)) {
                $transaction = $transaction->where('produk_id', $request->produk);
            }
        } else {
            $transaction = Transaction::where('tanggal', date('Y-m-d'))->get();
        }
        return view('accounting.filter', compact('bank', 'mitra', 'produk', 'transaction'));
    }

    public function exportfilter(Request $request)
    {

        $spreadsheet = IOFactory::load('excelTemplate/templateFilter.xlsx');
        $row = 7;
        if (count($request->all()) > 0) {
            $transaction = Transaction::all();
            if (!empty($request->tanggalawal)) {
                if (empty($request->tanggalakhir)) {
                    $request['tanggalakhir'] = $request->tanggalawal;
                }
                $transaction = $transaction->where('tanggal', '>=', date('Y-m-d', strtotime($request->tanggalawal)))->where('tanggal', '<=', date('Y-m-d', strtotime($request->tanggalakhir)));
            }

            if (!empty($request->bank)) {
                $transaction = $transaction->where('bank_id', $request->bank);
            }

            if (!empty($request->mitra)) {
                $transaction = $transaction->where('cid_id', $request->mitra);
            }

            if (!empty($request->produk)) {
                $transaction = $transaction->where('produk_id', $request->produk);
            }
        } else {
            $transaction = Transaction::where('tanggal', date('Y-m-d'))->get();
        }

        $jumlah = 0;
        foreach ($transaction as $trans) {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("B{$row}", "{$trans->tanggal}");
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("C{$row}", $trans->cid->nama_cid);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("D{$row}", $trans->kd->nama_kd);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("E{$row}", $trans->produk->nama_produk);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("F{$row}", $trans->bank->nama_bank);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("G{$row}", $trans->rekening);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("H{$row}", $trans->bulan);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("I{$row}", $trans->rptag);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("J{$row}", $trans->rpadm);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("K{$row}", $trans->total);
            $row++;
            $jumlah += $trans->total;
        }

        $row += 1;
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("J{$row}", 'Sub Total');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("K{$row}", $jumlah);


        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        ob_end_clean(); //
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=Reports Filter Transaksi_" . date('Y-m-d') . ".xlsx");
        $writer->save('php://output');
    }
}
