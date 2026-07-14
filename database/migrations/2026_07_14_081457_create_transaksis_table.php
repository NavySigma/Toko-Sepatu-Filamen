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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_invoice')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nama_pelanggan');
            $table->dateTime('tanggal_transaksi');
            $table->enum('metode_pembayaran', ['tunai', 'transfer', 'qris', 'kartu_debit', 'kartu_kredit'])->default('tunai');
            $table->enum('status', ['pending', 'selesai', 'dibatalkan'])->default('pending');
            $table->decimal('total_harga', 14, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
