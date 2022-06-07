<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cid;
use App\Models\Bank;
use App\Models\Produk;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MitraController extends Controller
{
    public function index()
    {
        $transactiontoday = Transaction::Valid()->whereDate('created_at', date('Y-m-d'))->where('cid_id', Cid::where('user_id', Auth::User()->id)->first()->kode_cid)->sum('bulan');
        $transactionRupiah = Transaction::Valid()->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->where('cid_id', Cid::where('user_id', Auth::User()->id)->first()->kode_cid)->sum('rptag');
        $bank = Bank::with('transaction')->get();

        $lastDay = date('d', strtotime(Carbon::now()->endOfMonth()->toDateString()));
        $pln = [];
        $non_pln = [];
        $tanggal = [];
        for ($i = 1; $i <= $lastDay; $i++) {
            $tanggal[] = $i;
            $pln[] = Transaction::Valid()->where('cid_id', Cid::where('user_id', Auth::User()->id)->first()->kode_cid)->whereMonth('tanggal', date('m'))->whereDay('tanggal', $i)->where(function ($query) {
                $query->where('produk_id', 99501)->orWhere('produk_id', 99504)->orWhere('produk_id', 99502);
            })->sum('bulan');
            $non_pln[] = Transaction::Valid()->where('cid_id', Cid::where('user_id', Auth::User()->id)->first()->kode_cid)->whereMonth('tanggal', date('m'))->whereDay('tanggal', $i)->where(function ($query) {
                $query->where('produk_id', '!=', 99501)->where('produk_id', '!=', 99504)->where('produk_id', '!=', 99502);
            })->count();
        }
        return view('mitra.index', compact('transactiontoday', 'transactionRupiah'))
            ->with(['tanggal' => json_encode($tanggal, JSON_NUMERIC_CHECK), 'pln' => json_encode($pln, JSON_NUMERIC_CHECK), 'non_pln' => json_encode($non_pln, JSON_NUMERIC_CHECK)]);
    }

    public function transaksiini()
    {
        $transactions =  Transaction::Valid()->with('cid', 'produk', 'bank', 'kd')->whereDate('created_at', date('Y-m-d'))->where('cid_id', Cid::where('user_id', Auth::User()->id)->first()->kode_cid)->get();
        return view('mitra.transaksiini', compact('transactions'));
    }

    public function transaksimonth()
    {
        $transactions =  Transaction::Valid()->with('cid', 'produk', 'bank', 'kd')->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->where('cid_id', Cid::where('user_id', Auth::User()->id)->first()->kode_cid)->get();
        return view('mitra.transaksimonth', compact('transactions'));
    }

    public function exportTransaksi()
    {
        $mitra = Cid::with('bank')->where('user_id', Auth::User()->id)->first();
        $nama = $mitra->nama_cid . " - " . @$mitra->bank->nama_bank;
        $spreadsheet = IOFactory::load('excelTemplate/templateMitra.xlsx');
        $produks = Transaction::Valid()->select('produk_id')->whereMonth('tanggal', date('m'))->where('cid_id', Cid::where('user_id', Auth::User()->id)->first()->kode_cid)->groupBy('produk_id')->get();
        $lastDay = date('d', strtotime(Carbon::now()->toDateString()));
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("B1", date("01-M-Y"));
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("B2", date("$lastDay-M-Y"));
        $rows = [
            ["B", "C", "D", "E", "F", "G"],
            ["J", "K", "L", "M", "N", "O"],
            ["R", "S", "T", "U", "V", "W"]
        ];
        $rowsProduk = ['A', 'I', 'Q'];
        $barisProduk = 11;
        $barisNamaMitra = 9;
        $index = 0;
        foreach ($produks as $produk) {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("{$rowsProduk[$index]}{$barisProduk}", Produk::where('kode_produk', $produk->produk_id)->first()->nama_produk);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("{$rowsProduk[$index]}{$barisNamaMitra}", $nama);
            $baris = 9;
            for ($i = 1; $i <= $lastDay; $i++) {
                $transaksi = DB::table('transaction')->select(DB::raw('sum(rekening) as pelanggan'), DB::raw('sum(bulan) as lembar'), DB::raw('sum(rptag) as tagihan'), DB::raw('sum(rpadm) as admin'), DB::raw('sum(total) as total'))->where('is_valid', 1)->where('cid_id', $mitra->kode_cid)->where('produk_id', $produk->produk_id)->whereMonth('tanggal', date('m'))->whereDay('tanggal', $i)->first();
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("{$rows[$index][0]}{$baris}", date("$i-M-Y"));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("{$rows[$index][1]}{$baris}", empty($transaksi->pelanggan) ? "-" : $transaksi->pelanggan);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("{$rows[$index][2]}{$baris}", empty($transaksi->lembar) ? "-" : $transaksi->lembar);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("{$rows[$index][3]}{$baris}", empty($transaksi->tagihan) ? "-" : $transaksi->tagihan);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("{$rows[$index][4]}{$baris}", empty($transaksi->admin) ? "-" : $transaksi->admin);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("{$rows[$index][5]}{$baris}", empty($transaksi->total) ? "-" : $transaksi->total);
                $baris++;
            }
            $index++;
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        ob_end_clean(); //
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=Report Transaksi Mitra_" . date('Ymdhis') . ".Xlsx");
        $writer->save('php://output');
    }

    public function getProduk($id)
    {
        $mitra = Cid::where('kode_cid', $id)->first();
        $transaksi = Transaction::with('produk')->select('produk_id')->where('cid_id', $mitra->kode_cid)->groupBy('produk_id')->get();
        return response()->json(['produk' => $transaksi]);
    }
}
