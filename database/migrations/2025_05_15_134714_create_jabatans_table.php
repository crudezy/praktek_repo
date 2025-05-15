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
        Schema::create('jabatan', function (Blueprint $table) {           
            $table->id(); // Kolom id (auto increment primary key)
            $table->string('nama_jabatan'); // Kolom nama_jabatan (varchar)
            $table->decimal('gaji', 15, 2); // Kolom gaji (decimal 15 digit, 2 angka di belakang koma)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan');
    }
};
