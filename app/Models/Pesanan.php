<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table='pesanan';
    protected $fillable=["menu_id","jumlah","total","no_meja","status"];
    protected $primaryKey = 'pesanan_id';
}
