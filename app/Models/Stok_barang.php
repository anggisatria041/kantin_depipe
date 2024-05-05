<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok_barang extends Model
{
    protected $connection = 'mysql';
    protected $table='stok_barang';
    protected $fillable=["nama","barcode","jumlah","satuan","harga"];
    protected $primaryKey = 'stok_barang_id';
}
