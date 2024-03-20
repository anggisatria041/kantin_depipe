<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventori', function (Blueprint $table) {
            $table->bigIncrements('inventori_id');
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->integer('harga_satuan');
            $table->date('tanggal_masuk');
            $table->integer('total_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventori');
    }
};
