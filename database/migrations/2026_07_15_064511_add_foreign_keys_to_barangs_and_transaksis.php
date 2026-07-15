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
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn('merk');
            $table->foreignId('merk_id')->nullable()->after('kategori')->constrained('merks')->nullOnDelete();
        });

        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('nama_pelanggan');
            $table->foreignId('pelanggan_id')->nullable()->after('nomor_invoice')->constrained('pelanggans')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropForeign(['merk_id']);
            $table->dropColumn('merk_id');
            $table->string('merk')->after('nama')->nullable();
        });

        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['pelanggan_id']);
            $table->dropColumn('pelanggan_id');
            $table->string('nama_pelanggan')->after('nomor_invoice')->nullable();
        });
    }
};
