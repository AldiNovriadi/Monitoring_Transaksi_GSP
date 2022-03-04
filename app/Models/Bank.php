<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'bank';

    protected $fillable = ['kode_bank', 'nama_bank', 'filegambar'];

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'bank_id', 'kode_bank');
    }
    

    use HasFactory;
}
