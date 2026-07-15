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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('email')->nullable()->after('kontak');
            $table->integer('jumlah_cat_disupply')->default(0)->after('alamat');
        });

        Schema::table('pelanggans', function (Blueprint $table) {
            $table->string('email')->nullable()->after('kontak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn(['email', 'jumlah_cat_disupply']);
        });

        Schema::table('pelanggans', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};
