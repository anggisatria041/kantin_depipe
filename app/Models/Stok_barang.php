<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok_barang extends Model
{
    protected $connection = 'mysql';
    protected $table='stok_barang';
    protected $fillable=["nama","barcode","stok","harga_beli","harga_jual"];
    protected $primaryKey = 'stok_barang_id';
}
