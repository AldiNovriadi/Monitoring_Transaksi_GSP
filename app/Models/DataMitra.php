<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMitra extends Model
{
    protected $table = 'mitra';
    protected $fillable = ['name', 'email', 'status'];

    use HasFactory;
}
