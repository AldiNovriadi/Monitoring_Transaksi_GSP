<?php

namespace App\Models;

use CurlHandle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transaction";

    protected $fillable = [
        'tanggal',
        'cid_id',
        'kd_id',
        'biller_id',
        'produk_id',
        'bank_id',
        'rekening',
        'bulan',
        'rptag',
        'rpadm',
        'total'
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'kode_bank');
    }

    public function biller()
    {
        return $this->belongsTo(Billers::class, 'biller_id', 'kode_biller');
    }

    public function kd()
    {
        return $this->belongsTo(Kd::class, 'kd_id', 'kode_kd');
    }

    public function cid()
    {
        return $this->belongsTo(Cid::class, 'cid_id', 'kode_cid');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'kode_produk');
    }
    use HasFactory;
}
