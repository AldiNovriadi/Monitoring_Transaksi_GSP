<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'bank';

    protected $fillable = ['kode_bank', 'nama_bank', 'filegambar', 'filetemplate', 'user_id'];

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'bank_id', 'kode_bank');
    }

    // public function bank()
    // {
    //     return $this->hasOne(DataMitra::class, 'bank_id');
    // }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    use HasFactory;
}
