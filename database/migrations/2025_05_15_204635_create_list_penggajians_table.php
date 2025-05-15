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
        Schema::create('list_penggajians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penggajian_id')->constrained('penggajian')->onDelete('cascade');
            $table->date('tgl_gaji');
            $table->string('jenis_penggajian');
            $table->dateTime('transaction_time')->nullable();
            $table->decimal('gross_amount',10,2);
            $table->string('order_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('status_code')->nullable();
            $table->string('transaction_id')->nullable();
            $table->dateTime('settlement_time')->nullable();
            $table->string('status_message')->nullable();
            $table->string('merchant_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_penggajians');
    }
};
