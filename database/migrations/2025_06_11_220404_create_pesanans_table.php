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
            $table->foreignId('pengguna_id')->nullable()->constrained('users')->nullOnDelete(); // pelanggan (boleh kosong)
            $table->foreignId('meja_id')->constrained('mejas')->onDelete('cascade');
            $table->string('kode_pesanan')->unique();
            $table->enum('metode_pembayaran', ['transfer_bank', 'e_wallet', 'tunai']);
            $table->enum('status_pembayaran', ['menunggu', 'dibayar', 'gagal'])->default('menunggu');
            $table->enum('status_pesanan', ['menunggu', 'diproses', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->integer('total_harga');
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
