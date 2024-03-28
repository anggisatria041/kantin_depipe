<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventori extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table='inventori';
    protected $fillable=["nama_barang","jumlah","harga_satuan","tanggal_masuk","total_bayar"];
    protected $primaryKey = 'inventori_id';
}
