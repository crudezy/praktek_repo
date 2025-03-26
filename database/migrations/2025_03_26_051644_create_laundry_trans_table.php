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
        Schema::create('laundry_trans', function (Blueprint $table) {
            $table->id();
            $table->string('id_pelanggan')->unique();
            $table->string('nama_pelanggan');
            $table->date('tanggal_order');
            $table->date('tanggal_pengambilan');
            $table->decimal('total_berat', 50, 2);
            $table->enum('paket_layanan', ['Laundry Kiloan', 'Dry Cleaning', 'Laundry Self Service', 'Laundry On Demand'])->default('Laundry Kiloan');
            $table->enum('status_laundry', ['Diproses', 'Selesai', 'Diambil'])->default('Diproses');
            $table->decimal('total_harga', 50, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laundry_trans');
    }
};
