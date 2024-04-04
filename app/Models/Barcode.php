<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    protected $connection = 'mysql';
    protected $table='barcode';
    protected $fillable=["barcode","no_meja"];
    protected $primaryKey = 'barcode_id';
}
