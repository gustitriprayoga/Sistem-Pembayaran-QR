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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daftar_meja_id')->constrained('daftar_mejas');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('nama_pelanggan')->nullable();
            $table->decimal('total_bayar', 10, 2);
            $table->enum('status_pesanan', ['baru', 'diproses', 'selesai', 'dibatalkan'])->default('baru');
            $table->enum('status_bayar', ['menunggu', 'lunas', 'gagal'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
