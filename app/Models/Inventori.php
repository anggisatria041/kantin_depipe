<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventori extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table='inventori';
    protected $fillable=["stok_barang_id","tanggal_pembelian","jumlah_pembelian","total_bayar"];
    protected $primaryKey = 'inventori_id';
}
