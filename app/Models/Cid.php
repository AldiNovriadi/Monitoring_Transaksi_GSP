<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cid extends Model
{
    protected $table = 'cid';
    protected $fillable = ['kode_cid', 'nama_cid'];

    public function transactioncid()
    {
        return $this->hasMany(Transaction::class, 'cid_id', 'kode_cid');
    }

    use HasFactory;
}
