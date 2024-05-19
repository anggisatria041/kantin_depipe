<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $connection = 'mysql';
    protected $table='penjualan';
    protected $fillable=[
        "no_transaksi",
        "karyawan_id",
        "tanggal",
        "produk",
        "total_bayar",
        "pelanggan",
        "cash"
    ];
    protected $primaryKey = 'penjualan_id';
}
