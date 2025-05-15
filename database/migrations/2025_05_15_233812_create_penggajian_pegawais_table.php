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
        Schema::create('penggajian_pegawais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penggajian_id')->constrained('penggajian')->onDelete('cascade'); // Relasi ke tabel penjualan
            $table->foreignId('id_jabatan')->constrained('jabatan')->onDelete('cascade'); // Relasi ke tabel layanans
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
        Schema::dropIfExists('penggajian_pegawais');
    }
};
