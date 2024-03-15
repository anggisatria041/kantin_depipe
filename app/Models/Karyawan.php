<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table='karyawan';
    protected $fillable=["nama","no_hp","alamat","divisi"];
    protected $primaryKey = 'karyawan_id';
}
