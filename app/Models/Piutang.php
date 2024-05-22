<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table='piutang';
    protected $fillable=["karyawan_id","jumlah","no_transaksi"];
    protected $primaryKey = 'piutang_id';
}
