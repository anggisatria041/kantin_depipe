<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table='saldo';
    protected $fillable=["karyawan_id","saldo"];
    protected $primaryKey = 'saldo_id';
}
