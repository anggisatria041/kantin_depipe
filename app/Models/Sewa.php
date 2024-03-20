<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    use HasFactory;
    protected $table='sewa';
    protected $fillable=["tenant_id","tgl_sewa","tgl_berakhir","harga","level","status"];
    protected $primaryKey = 'sewa_id';
}
