<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMitra extends Model
{
    protected $table = 'mitra';
    protected $fillable = ['name', 'email', 'status', 'role', 'bank_id'];

    use HasFactory;


    public function akun()
    {
        return $this->hasOne(User::class, 'email', 'email');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
