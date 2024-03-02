<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table='menu';
    protected $fillable=["nama","deskripsi","gambar","harga"];
    protected $primaryKey = 'menu_id';
}