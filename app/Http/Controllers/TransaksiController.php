<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Billers;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use PhpOffice\PhpSpreadsheet\IOFactory;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaction = Transaction::where('tanggal', date('Y-m-d'))->get();
        $transactiontoday = Transaction::where('tanggal', date('Y-m-d'))->count();
        $transactionmount = Transaction::whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->count();
        $transactionbank = Bank::all()->count();
        $transactionbiller = Billers::all()->count();

        return view('transaksi.index', ['transaction' => $transaction, 'transactiontoday' => $transactiontoday, 'transactionmount' => $transactionmount, 'transactionbank' => $transactionbank, 'transactionbiller' => $transactionbiller]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function transactiontoday()
    {
        $transaction = Transaction::where('tanggal', date('Y-m-d'))->get();
        return view('transaksi.transactiontoday', ['transaction' => $transaction]);
    }

    public function transactionmonth()
    {
        $transaction = Transaction::whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->get();
        return view('transaksi.transactionmonth', ['transaction' => $transaction]);
    }

    public function listtransaksipln()
    {
        $bank = Bank::with('transaction')->get();

        return view('transaksi.listtransaksipln', ['bank' => $bank]);
    }

    public function listtransaksiplnmonth()
    {
        $bankmonth = Bank::with(['transaction' => function ($query) {
            $query->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'));
        }])->get();

        return view('transaksi.listtransaksiplnmonth', ['bankmonth' => $bankmonth]);
    }

    public function listtransaksinonpln()
    {
        $biller = Billers::with('transactionbiller')->get();

        return view('transaksi.listtransaksinonpln', ['biller' => $biller]);
    }

    public function listtransaksinonplnmonth()
    {
        $billermonth = Billers::with(['transactionbiller' => function ($query) {
            $query->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'));
        }])->get();

        return view('transaksi.listtransaksinonplnmonth', ['billermonth' => $billermonth]);
    }

    public function detailmitra($kode)
    {
        $bank = Bank::where('kode_bank', $kode)->first();
        $trans = Transaction::where('bank_id', $kode)->where('tanggal', date('Y-m-d'))->get();
        return view('transaksi.detailmitra', ['trans' => $trans, 'bank' => $bank]);
    }

    public function detailmitramonth($kode)
    {
        $bank = Bank::where('kode_bank', $kode)->first();
        $trans = Transaction::where('bank_id', $kode)->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->get();
        return view('transaksi.detailmitramonth', ['trans' => $trans, 'bank' => $bank]);
    }

    public function detailbiller($kode)
    {
        $biller = Billers::where('kode_biller', $kode)->first();
        $transbiller = Transaction::where('biller_id', $kode)->where('tanggal', date('Y-m-d'))->get();
        return view('transaksi.detailbiller', ['transbiller' => $transbiller, 'biller' => $biller]);
    }

    public function detailbillermonth($kode)
    {
        $biller = Billers::where('kode_biller', $kode)->first();
        $transbiller = Transaction::where('biller_id', $kode)->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->get();
        return view('transaksi.detailbillermonth', ['transbiller' => $transbiller, 'biller' => $biller]);
    }

    public function export()
    {
        $spreadsheet = IOFactory::load('excelTemplate/Bank_BNI.xls');
        // $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        // $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $row = 208;
        $partner = 207;
        $no = 1;
        foreach (Transaction::all() as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue("C{$partner}", "{$data->cid->nama_cid}")
                ->setCellValue("C{$row}", "{$data->cid->nama_cid}")
                ->setCellValue("D{$row}", "{$data->kd->nama_kd}")
                ->setCellValue("E{$row}", "{$data->tanggal}")
                ->setCellValue("F{$row}", "{$data->rekening}")
                ->setCellValue("G{$row}", "{$data->bulan}")
                ->setCellValue("H{$row}", "{$data->rptag}")
                ->setCellValue("I{$row}", "{$data->rpadm}")
                ->setCellValue("J{$row}", "{$data->total}");
            $row++;
            $no++;
        }
        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        ob_end_clean(); //
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=Report Transaksi Bank BNI_" . date('Ymdhis') . ".xls");
        $writer->save('php://output');
    }
}
