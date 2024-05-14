<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $connection = 'mysql';
    protected $table='penjualan';
    protected $fillable=[
        "stok_barang_id",
        "no_transaksi",
        "tanggal",
        "jumlah",
        "total_bayar",
        "pelanggan",
        "cash",
        "status"
    ];
    protected $primaryKey = 'penjualan_id';
}
