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
        Schema::create('penjualan_layanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_id')->constrained('penjualan')->onDelete('cascade'); // Relasi ke tabel penjualan
            $table->foreignId('id_layanan')->constrained('layanans')->onDelete('cascade'); // Relasi ke tabel layanans
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->integer('jml'); // Jumlah layanan yang dibeli
            $table->date('tgl');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_layanan');
    }
};