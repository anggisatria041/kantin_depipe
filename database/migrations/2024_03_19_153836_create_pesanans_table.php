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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->bigIncrements('pesanan_id');
            $table->integer('order_id');
            $table->string('keterangan');
            $table->string('pesanan');
            $table->string('jenis_pemesanan');
            $table->string('metode_pembayaran');
            $table->string('status_pemesanan');
            $table->string('status_pembayaran');
            $table->integer('no_meja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
