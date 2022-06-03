<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cid;
use App\Models\Bank;
use App\Models\Produk;
use App\Models\Billers;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Middleware\Mitra;
use PhpParser\Node\Expr\Empty_;
use Illuminate\Support\Facades\DB;
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
        $transaction = Transaction::Valid()->whereDate('created_at', date('Y-m-d'))->get();
        $transactiontoday = Transaction::Valid()->whereDate('created_at', date('Y-m-d'))->count();
        $transactionmount = Transaction::Valid()->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->count();
        $transactionbank = Bank::all()->count();
        $transactionbiller = Billers::all()->count();

        $lastDay = date('d', strtotime(Carbon::now()->endOfMonth()->toDateString()));
        $pln = [];
        $non_pln = [];
        $tanggal = [];
        for ($i = 1; $i <= $lastDay; $i++) {
            $tanggal[] = $i;
            $pln[] = Transaction::Valid()->whereMonth('tanggal', date('m'))->whereDay('tanggal', $i)->where(function ($query) {
                $query->where('produk_id', 99501)->orWhere('produk_id', 99504)->orWhere('produk_id', 99502);
            })->count();
            $non_pln[] = Transaction::Valid()->whereMonth('tanggal', date('m'))->whereDay('tanggal', $i)->where(function ($query) {
                $query->where('produk_id', '!=', 99501)->where('produk_id', '!=', 99504)->where('produk_id', '!=', 99502);
            })->count();
        }

        return view('transaksi.index', ['transaction' => $transaction, 'transactiontoday' => $transactiontoday, 'transactionmount' => $transactionmount, 'transactionbank' => $transactionbank, 'transactionbiller' => $transactionbiller])
            ->with(['tanggal' => json_encode($tanggal, JSON_NUMERIC_CHECK), 'pln' => json_encode($pln, JSON_NUMERIC_CHECK), 'non_pln' => json_encode($non_pln, JSON_NUMERIC_CHECK)]);
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
        return view('transaksi.filter', compact('bank', 'mitra', 'produk', 'transaction'))->with($data);
    }

    public function transactiontoday()
    {
        $transactionPending = Transaction::NotValid()->whereDate('created_at', date('Y-m-d'))->get();
        $transactionFix = Transaction::Valid()->whereDate('created_at', date('Y-m-d'))->get();
        return view('transaksi.transactiontoday', ['transactionPending' => $transactionPending, 'transactionFix' => $transactionFix]);
    }

    public function transactionmonth()
    {
        $transaction = Transaction::Valid()->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->get();
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
            $query->Valid()->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'));
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
            $query->Valid()->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'));
        }])->get();

        return view('transaksi.listtransaksinonplnmonth', ['billermonth' => $billermonth]);
    }

    public function detailmitra($kode)
    {
        $bank = Bank::where('kode_bank', $kode)->first();
        $trans = Transaction::Valid()->where('bank_id', $kode)->whereDate('created_at', date('Y-m-d'))->get();
        return view('transaksi.detailmitra', ['trans' => $trans, 'bank' => $bank]);
    }

    public function detailmitramonth($kode)
    {
        $bank = Bank::where('kode_bank', $kode)->first();
        $trans = Transaction::Valid()->where('bank_id', $kode)->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->get();
        return view('transaksi.detailmitramonth', ['trans' => $trans, 'bank' => $bank]);
    }

    public function detailbiller($kode)
    {
        $biller = Billers::where('kode_biller', $kode)->first();
        $transbiller = Transaction::Valid()->where('biller_id', $kode)->whereDate('created_at', date('Y-m-d'))->get();
        return view('transaksi.detailbiller', ['transbiller' => $transbiller, 'biller' => $biller]);
    }

    public function detailbillermonth($kode)
    {
        $biller = Billers::where('kode_biller', $kode)->first();
        $transbiller = Transaction::Valid()->where('biller_id', $kode)->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->get();
        return view('transaksi.detailbillermonth', ['transbiller' => $transbiller, 'biller' => $biller]);
    }

    public function result($id)
    {
        $report = \App\Models\Transaction::Valid()->get();

        $categories = [];

        foreach ($report as $reports) {
            $categories[] = $reports->description;
            $jumlah[] = $reports->voters->count();
            // dd(json_encode($categories));    
        }
        return view('voting.result', ['categories' => $categories, 'jumlah' => $jumlah]);
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
        header("Content-Disposition: attachment; filename=Report Filter Transaksi_" . date('Y-m-d') . ".xlsx");
        $writer->save('php://output');
    }

    public function export($kd)
    {
        $bank = Bank::where('kode_bank', $kd)->first();
        // $spreadsheet = IOFactory::load('excelTemplate/Bank_BNI1.xls');
        $spreadsheet = IOFactory::load('excelTemplate/' . $bank->filetemplate);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("B3", date("d F Y"));
        // $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        // $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $row = 9;
        $partner = 8;
        $no = 1;
        $cid = Transaction::Valid()->select('cid_id')->with('cid')->where('bank_id', $kd)->groupBy('cid_id')->get();
        $aggregator = [];
        $nonAggregator = [];
        foreach ($cid as $data) {
            if ($data->cid->jenis == 'Aggregator') {
                $aggregator[] = $data;
            } else {
                $nonAggregator[] = $data;
            }
        }


        foreach ($nonAggregator as $data) {

            $produks = DB::table('transaction')->select('produk_id', 'tanggal', DB::raw('sum(rekening) as pelanggan'), DB::raw('sum(bulan) as lembar'), DB::raw('sum(rptag) as tagihan'), DB::raw('sum(rpadm) as admin'), DB::raw('sum(total) as total'))->where('is_valid', 1)->where('cid_id', $data->cid_id)->whereDate('created_at', date('Y-m-d'))->groupBy('produk_id', 'tanggal')->get();

            $spreadsheet->setActiveSheetIndex(0)->setCellValue("C{$partner}", "{$data->cid->nama_cid}");

            foreach ($produks as $produk) {
                $namaProduk = Produk::select('nama_produk')->where('kode_produk', $produk->produk_id)->first();
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("C{$row}", "{$namaProduk->nama_produk}");
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("D{$row}", $namaProduk->nama_produk);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("E{$row}", $produk->tanggal);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("F{$row}", $produk->pelanggan);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("G{$row}", $produk->lembar);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("H{$row}", $produk->tagihan);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("i{$row}", $produk->admin);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("j{$row}", $produk->total);
                $row++;
            }
            $partner += 17;
            $row  = $partner + 1;
            // $spreadsheet->setActiveSheetIndex(0)
            //     ->setCellValue("C{$partner}", "{$data->cid->nama_cid}")
            //     ->setCellValue("C{$row}", "{$data->cid->nama_cid}")
            //     ->setCellValue("D{$row}", "{$data->kd->nama_kd}")
            //     ->setCellValue("E{$row}", "{$data->tanggal}")
            //     ->setCellValue("F{$row}", "{$data->rekening}")
            //     ->setCellValue("G{$row}", "{$data->bulan}")
            //     ->setCellValue("H{$row}", "{$data->rptag}")
            //     ->setCellValue("I{$row}", "{$data->rpadm}")
            //     ->setCellValue("J{$row}", "{$data->total}");
            // $row++;
            // $no++;
        }
        $produk = ['99501', '99502', '99504'];
        $cid_id = [];
        foreach ($nonAggregator as $data) {
            $cid_id[] = $data->cid_id;
        }

        if ($bank->kode_bank == 9) {
            $rowAggregator = 93;
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("C{$rowAggregator}", "Aggregator");
            foreach ($produk as $data) {
                $rowAggregator++;
                $produkAggregator = DB::table('transaction')->select('produk_id', 'tanggal', DB::raw('sum(rekening) as pelanggan'), DB::raw('sum(bulan) as lembar'), DB::raw('sum(rptag) as tagihan'), DB::raw('sum(rpadm) as admin'), DB::raw('sum(total) as total'))->where('is_valid', 1)->whereIn('cid_id', $cid_id)->where('produk_id', $data)->whereDate('created_at', date('Y-m-d'))->groupBy('produk_id', 'tanggal')->first();
                if (!empty($produkAggregator)) {
                    $namaProduk = Produk::select('nama_produk')->where('kode_produk', $produkAggregator->produk_id)->first();
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue("C{$rowAggregator}", "{$namaProduk->nama_produk}");
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue("D{$rowAggregator}", $namaProduk->nama_produk);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue("E{$rowAggregator}", $produkAggregator->tanggal);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue("F{$rowAggregator}", $produkAggregator->pelanggan);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue("G{$rowAggregator}", $produkAggregator->lembar);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue("H{$rowAggregator}", $produkAggregator->tagihan);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue("i{$rowAggregator}", $produkAggregator->admin);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue("j{$rowAggregator}", $produkAggregator->total);
                }
            }
        }
        // $rowDistribusi = 118;

        // foreach ($produk as $data) {

        //     $produkDistribusi = DB::table('transaction')->select('produk_id', 'tanggal', DB::raw('sum(rekening) as pelanggan'), DB::raw('sum(bulan) as lembar'), DB::raw('sum(rptag) as tagihan'), DB::raw('sum(rpadm) as admin'), DB::raw('sum(total) as total'))->where('produk_id', $data)->where('tanggal', date('Y-m-d'))->groupBy('produk_id', 'tanggal')->first();
        //     if (!empty($produkDistribusi)) {
        //         $namaProduk = Produk::select('nama_produk')->where('kode_produk', $produkDistribusi->produk_id)->first();
        //         $spreadsheet->setActiveSheetIndex(0)->setCellValue("C{$rowDistribusi}", "{$namaProduk->nama_produk}");
        //         $spreadsheet->setActiveSheetIndex(0)->setCellValue("D{$rowDistribusi}", "{$produkDistribusi->tanggal}");
        //         $spreadsheet->setActiveSheetIndex(0)->setCellValue("E{$rowDistribusi}", $produkDistribusi->pelanggan);
        //         $spreadsheet->setActiveSheetIndex(0)->setCellValue("F{$rowDistribusi}", $produkDistribusi->lembar);
        //         $spreadsheet->setActiveSheetIndex(0)->setCellValue("G{$rowDistribusi}", $produkDistribusi->tagihan);
        //         $spreadsheet->setActiveSheetIndex(0)->setCellValue("H{$rowDistribusi}", $produkDistribusi->admin);
        //         $spreadsheet->setActiveSheetIndex(0)->setCellValue("I{$rowDistribusi}", $produkDistribusi->total);
        //         $rowDistribusi++;
        //     }
        // }


        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        ob_end_clean(); //
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=Report Transaksi Bank BNI_" . date('Ymdhis') . ".xls");
        $writer->save('php://output');
    }

    public function validateTran()
    {
        $transaction = Transaction::NotValid()->whereDate('created_at', date('Y-m-d'))->update([
            'is_valid' => 1
        ]);
        toast('Data Berhasil Divalidasi', 'success');
        return back();
    }

    public function deletePendingTran()
    {
        $transaction = Transaction::NotValid()->whereDate('created_at', date('Y-m-d'))->delete();
        toast('Data Berhasil Dihapus', 'success');
        return back();
    }
}
