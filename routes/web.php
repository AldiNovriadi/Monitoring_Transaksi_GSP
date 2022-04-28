<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\KelolabankController;
use App\Http\Controllers\KelolabillerController;
use App\Http\Controllers\KelolamitraController;
use App\Models\User;
use App\Models\Transaction;
use App\Imports\UsersImport;
use App\Imports\TransactionImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\TransaksiController;
use Maatwebsite\Excel\Row;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();
// Route::get('/admin', 'AdminController@index')->name('admin')->middleware('admin');
// Route::get('/mitra', 'MitraController@index')->name('mitra')->middleware('mitra');

Route::post('/importTransaksi', function () {
    Excel::import(new TransactionImport, request()->file('file'));
    return back();
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/transaksi/detailmitra/{kode}', [TransaksiController::class, 'detailmitra']);
    Route::get('/transaksi/detailmitramonth/{kode}', [TransaksiController::class, 'detailmitramonth']);
    Route::get('/transaksi/detailbiller/{kode}', [TransaksiController::class, 'detailbiller']);
    Route::get('/transaksi/detailbillermonth/{kode}', [TransaksiController::class, 'detailbillermonth']);
    Route::get('/transaksi/listtransaksipln', [TransaksiController::class, 'listtransaksipln']);
    Route::get('/transaksi/listtransaksiplnmonth', [TransaksiController::class, 'listtransaksiplnmonth']);
    Route::get('/transaksi/listtransaksinonpln', [TransaksiController::class, 'listtransaksinonpln']);
    Route::get('/transaksi/listtransaksinonplnmonth', [TransaksiController::class, 'listtransaksinonplnmonth']);
    Route::get('file-import-export', [UserController::class, 'fileImportExport']);
    Route::get('/file-export/{kd}', [TransaksiController::class, 'export'])->name('file-export');
    Route::get('/file-exportadmin', [TransaksiController::class, 'exportfilter'])->name('file-export');
    Route::get('/file-exportaccounting', [AccountingController::class, 'exportfilter'])->name('file-export');
    Route::get('/transaksi/filter', [TransaksiController::class, 'filter']);
    Route::get('/transaksi/today', [TransaksiController::class, 'transactiontoday']);
    Route::get('/transaksi/month', [TransaksiController::class, 'transactionmonth']);
    Route::get('/bank', [BankController::class, 'index']);
    Route::get('/bank/transaksi', [BankController::class, 'transaksiini']);
    Route::get('/bank/transaksimonth', [BankController::class, 'transaksimonth']);
    Route::get('/mitra', [MitraController::class, 'index']);
    Route::get('/mitra/transaksi', [MitraController::class, 'transaksiini']);
    Route::get('/accounting', [AccountingController::class, 'index']);
    Route::get('/accounting/transaksi', [AccountingController::class, 'transaksi']);
    Route::get('/accounting/detailtransaksi', [AccountingController::class, 'detailtransaksi']);
    Route::get('/accounting/filter', [AccountingController::class, 'filter']);
    Route::get('/accounting/laporan', [AccountingController::class, 'laporan']);
    Route::Resource('/transaksi', TransaksiController::class);
    Route::Resource('/account', AccountController::class);
    Route::Resource('/kelolabank', KelolabankController::class);
    Route::Resource('/kelolabiller', KelolabillerController::class);
    Route::Resource('/kelolamitra', KelolamitraController::class);
});
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/register', [LoginController::class, 'register']);
Route::post('/register', [LoginController::class, 'actionregis']);
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);
