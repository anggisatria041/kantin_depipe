<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table='kategori';
    protected $fillable=["nama_kategori"];
    protected $primaryKey = 'kategori_id';
}
