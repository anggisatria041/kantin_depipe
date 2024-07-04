<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table='pembayaran';
    protected $fillable=["tenant_id","jenis_pembayaran","no_rek","foto"];
    protected $primaryKey = 'pembayaran_id';
}
