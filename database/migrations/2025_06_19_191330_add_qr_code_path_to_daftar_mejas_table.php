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
        Schema::table('daftar_mejas', function (Blueprint $table) {
            // Tambahkan kolom ini setelah 'nama_meja'
            $table->string('qr_code_path')->nullable()->after('nama_meja');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daftar_mejas', function (Blueprint $table) {
            $table->dropColumn('qr_code_path');
        });
    }
};
