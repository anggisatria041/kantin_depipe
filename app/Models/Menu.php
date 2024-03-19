<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table='menu';
    protected $fillable=["tenant_id","nama","stok","kategori","gambar","harga","deskripsi"];
    protected $primaryKey = 'menu_id';
}
