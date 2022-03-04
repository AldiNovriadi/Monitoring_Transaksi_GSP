<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kd extends Model
{
    protected $table = 'kd';
    protected $fillable = ['kode_kd', 'nama_kd'];

    public function transactionkd()
    {
        return $this->hasMany(Transaction::class, 'kd_id', 'kode_kd');
    }

    use HasFactory;
}
