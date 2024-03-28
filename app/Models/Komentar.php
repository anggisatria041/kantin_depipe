<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table='komentar';
    protected $fillable=["menu_id","komentar"];
    protected $primaryKey = 'komentar_id';
}
