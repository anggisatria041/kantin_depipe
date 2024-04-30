<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table='pesanan';
    protected $fillable=["order_id","keterangan","pesanan","jenis_pemesanan","metode_pembayaran","status_pemesanan","status_pembayaran","no_meja"];
    protected $primaryKey = 'pesanan_id';
}
