<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    protected $table='gaji';
    protected $fillable=["karyawan_id","jumlah","tanggal","status"];
    protected $primaryKey = 'gaji_id';
}
