<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cid;
use App\Models\Bank;
use App\Models\Produk;
use App\Models\Billers;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AccountingController extends Controller
{
    public function index()
    {
        $transaction = Transaction::Valid()->where('tanggal', date('Y-m-d'))->get();
        $transactiontoday = Transaction::Valid()->whereDate('created_at', date('Y-m-d'))->sum("bulan");
        $transactionmount = Transaction::Valid()->whereDate('created_at', date('Y-m-d'))->sum("rptag");

        $lastDay = date('d', strtotime(Carbon::now()->endOfMonth()->toDateString()));
        $pln = [];
        $non_pln = [];
        $tanggal = [];
        for ($i = 1; $i <= $lastDay; $i++) {
            $tanggal[] = $i;
            $pln[] = Transaction::Valid()->whereMonth('tanggal', date('m'))->whereDay('tanggal', $i)->where(function ($query) {
                $query->where('produk_id', 99501)->orWhere('produk_id', 99504)->orWhere('produk_id', 99502);
            })->sum("bulan");
            $non_pln[] = Transaction::Valid()->whereMonth('tanggal', date('m'))->whereDay('tanggal', $i)->where(function ($query) {
                $query->where('produk_id', '!=', 99501)->where('produk_id', '!=', 99504)->where('produk_id', '!=', 99502);
            })->count();
        }

        return view('accounting.index', ['transaction' => $transaction, 'transactiontoday' => $transactiontoday, 'transactionmount' => $transactionmount])
            ->with(['tanggal' => json_encode($tanggal, JSON_NUMERIC_CHECK), 'pln' => json_encode($pln, JSON_NUMERIC_CHECK), 'non_pln' => json_encode($non_pln, JSON_NUMERIC_CHECK)]);
    }

    public function transaksi()
    {
        $transaction = DB::table('transaction')->select('produk_id', 'tanggal', 'cid_id', DB::raw('sum(bulan) as lembar'), DB::raw('sum(rptag) as tagihan'))->where('is_valid', 1)->whereDate('created_at', date('Y-m-d'))->groupBy('cid_id', 'produk_id', 'tanggal')->get();
        // $transaction = Transaction::where('tanggal', date('Y-m-d'))->get();

        return view('accounting.transaksi', compact('transaction'));
    }

    public function detailtransaksi()
    {
        // $transaction = Transaction::where('tanggal', date('Y-m-d'))->get();
        $transaction = DB::table('transaction')->select('tanggal', 'cid_id', DB::raw('sum(bulan) as lembar'), DB::raw('sum(rptag) as tagihan'))->where('is_valid', 1)->whereDate('created_at', date('Y-m-d'))->groupBy('cid_id', 'tanggal')->get();

        return view('accounting.detailtransaksi', compact('transaction'));
    }

    public function laporan()
    {
        $bankmonths = null;
        $months = [
            ['01', 'Januari'],
            ['02', 'Februari'],
            ['03', 'Maret'],
            ['04', 'April'],
            ['05', 'Mei'],
            ['06', 'Juni'],
            ['07', 'Juli'],
            ['08', 'Agustus'],
            ['09', 'September'],
            ['10', 'Oktober'],
            ['11', 'November'],
            ['12', 'Desember']
        ];

        foreach ($months as $month) {
            $bankmonths[] = [
                'kd_bulan' => $month[0],
                'bulan' => $month[1],
                'jumlah' => Transaction::Valid()->whereMonth('tanggal', $month[0])->whereYear('tanggal', date('Y'))->sum("bulan")
            ];
        }
        return view('accounting.laporan', compact('bankmonths'));
    }

    public function filter(Request $request)
    {
        $bank = Bank::all()->sortBy('nama_bank');
        $mitra = Cid::all()->sortBy('nama_cid');
        $produk = Produk::all()->sortBy('nama_produk');
        $data[] = null;

        if (count($request->all()) > 0) {
            $transaction = Transaction::Valid()->get();
            if (!empty($request->tanggalawal)) {
                if (empty($request->tanggalakhir)) {
                    $request['tanggalakhir'] = $request->tanggalawal;
                }
                $transaction = $transaction->where('tanggal', '>=', date('Y-m-d', strtotime($request->tanggalawal)))->where('tanggal', '<=', date('Y-m-d', strtotime($request->tanggalakhir)));
            }

            if (!empty($request->bank)) {
                $select_bank = Bank::where('kode_bank', $request->bank)->first();
                $data['list_mitra'] = Cid::where('bank_id', $select_bank->id)->get();
                $transaction = $transaction->where('bank_id', $request->bank);
            }

            if (!empty($request->mitra)) {
                $data['list_produk'] = Transaction::with('produk')->select('produk_id')->where('cid_id', $request->mitra)->groupBy('produk_id')->get();
                $transaction = $transaction->where('cid_id', $request->mitra);
            }

            if (!empty($request->produk)) {
                $transaction = $transaction->where('produk_id', $request->produk);
            }
        } else {
            $transaction = Transaction::Valid()->where('tanggal', date('Y-m-d'))->get();
        }
        return view('accounting.filter', compact('bank', 'mitra', 'produk', 'transaction'))->with($data);
    }

    public function exportfilter(Request $request)
    {

        $spreadsheet = IOFactory::load('excelTemplate/templateFilter.xlsx');
        $row = 7;
        if (count($request->all()) > 0) {
            $transaction = Transaction::Valid()->get();
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
            $transaction = Transaction::Valid()->where('tanggal', date('Y-m-d'))->get();
        }

        $jumlahpelanggan = 0;
        $jumlahlembar = 0;
        $jumlahrptag = 0;
        $jumlahrpadm = 0;
        $jumlahtotal = 0;
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
            $jumlahpelanggan += $trans->rekening;
            $jumlahlembar += $trans->bulan;
            $jumlahrptag += $trans->rptag;
            $jumlahrpadm += $trans->rpadm;
            $jumlahtotal += $trans->total;
        }

        $row += 1;
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("F{$row}", 'Sub Total');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("G{$row}", $jumlahpelanggan);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("H{$row}", $jumlahlembar);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("I{$row}", $jumlahrptag);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("J{$row}", $jumlahrpadm);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("K{$row}", $jumlahtotal);


        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        ob_end_clean(); //
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=Reports Filter Transaksi_" . date('Y-m-d') . ".xlsx");
        $writer->save('php://output');
    }

    public function exportTransaksi()
    {
        $transactions = DB::table('transaction')->select('produk_id', 'tanggal', 'cid_id', DB::raw('sum(bulan) as lembar'), DB::raw('sum(rptag) as tagihan'))->where('is_valid', 1)->whereDate('created_at', date('Y-m-d'))->groupBy('cid_id', 'produk_id', 'tanggal')->get();
        $spreadsheet = IOFactory::load('excelTemplate/templateAccounting-Today.xlsx');
        $row = 7;
        $jumlahLembar = 0;
        $jumlahFee = 0;
        foreach ($transactions as $transaction) {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("B{$row}", "{$transaction->tanggal}");
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("C{$row}", Cid::where('kode_cid', $transaction->cid_id)->first()->nama_cid);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("D{$row}", Produk::where('kode_produk', $transaction->produk_id)->first()->nama_produk);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("E{$row}", $transaction->lembar);
            // $spreadsheet->setActiveSheetIndex(0)->setCellValue("F{$row}", "Rp. " . number_format($transaction->tagihan));
            $row++;
            $jumlahLembar += $transaction->lembar;
            $jumlahFee += $transaction->tagihan;
        }

        $row += 1;
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("D{$row}", 'Sub Total');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("E{$row}", $jumlahLembar);
        // $spreadsheet->setActiveSheetIndex(0)->setCellValue("F{$row}", $jumlahFee);


        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        ob_end_clean(); //
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=Reports Transaksi_" . date('Y-m-d') . ".xlsx");
        $writer->save('php://output');
    }

    public function exportDetailTransaksi()
    {
        $transactions = DB::table('transaction')->select('tanggal', 'cid_id', DB::raw('sum(bulan) as lembar'), DB::raw('sum(rptag) as tagihan'))->where('is_valid', 1)->whereDate('created_at', date('Y-m-d'))->groupBy('cid_id', 'tanggal')->get();
        $spreadsheet = IOFactory::load('excelTemplate/templateAccounting-Detail.xlsx');
        $row = 7;
        $jumlahLembar = 0;
        $jumlahFee = 0;
        foreach ($transactions as $transaction) {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("B{$row}", "{$transaction->tanggal}");
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("C{$row}", Cid::where('kode_cid', $transaction->cid_id)->first()->nama_cid);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("D{$row}", $transaction->lembar);
            // $spreadsheet->setActiveSheetIndex(0)->setCellValue("E{$row}", "Rp. " . number_format($transaction->tagihan));
            $row++;
            $jumlahLembar += $transaction->lembar;
            $jumlahFee += $transaction->tagihan;
        }

        $row += 1;
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("C{$row}", 'Sub Total');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("D{$row}", $jumlahLembar);
        // $spreadsheet->setActiveSheetIndex(0)->setCellValue("E{$row}", $jumlahFee);


        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        ob_end_clean(); //
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=Reports Detail Transaksi_" . date('Y-m-d') . ".xlsx");
        $writer->save('php://output');
    }

    public function monthReport(Request $request)
    {
        $months = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
        try {
            $month = $months[$request->month];
        } catch (Exception $e) {
            abort('404');
        }
        $year = $request->get('year');

        $transaction = DB::table('transaction')->select('produk_id', 'tanggal', 'cid_id', DB::raw('sum(bulan) as lembar'), DB::raw('sum(rptag) as tagihan'))->where('is_valid', 1)->whereMonth('tanggal', $request->get('month'))->whereYear('tanggal', $request->get('year'))->groupBy('cid_id', 'produk_id', 'tanggal')->get();
        return view('accounting.detaillaporan', compact('transaction', 'month', 'year'));
    }
}
