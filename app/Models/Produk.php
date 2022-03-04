<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = ['kode_produk', 'nama_produk'];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    use HasFactory;
}
