<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cid extends Model
{
    protected $table = 'cid';
    protected $fillable = ['kode_cid', 'nama_cid','filetemplate','jenis','bank_id','user_id'];

    public function transactioncid()
    {
        return $this->hasMany(Transaction::class, 'cid_id', 'kode_cid');
    }

    public function Bank(){
        return $this->belongsTo(Bank::class,'bank_id');
    }

    public function User(){
        return $this->belongsTo(User::class,'user_id');
    }

    use HasFactory;
}
