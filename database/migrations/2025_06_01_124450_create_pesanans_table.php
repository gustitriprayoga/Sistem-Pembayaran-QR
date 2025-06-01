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
            $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggans')->onDelete('set null');
            $table->string('kode_pesanan')->unique();
            $table->enum('status', ['menunggu', 'dibayar', 'diproses', 'selesai'])->default('menunggu');
            $table->enum('metode_pembayaran', ['qris', 'e-wallet', 'transfer_bank', 'cod', 'tunai'])->default('qris');
            $table->string('saluran_pembayaran')->nullable();
            $table->string('referensi_pembayaran')->nullable();
            $table->integer('total_harga');
            $table->string('qr_code')->nullable();
            $table->timestamp('dibayar_pada')->nullable();
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
