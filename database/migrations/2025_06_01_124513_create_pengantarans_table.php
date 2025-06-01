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
        Schema::create('pengantarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
            $table->text('alamat');
            $table->text('catatan')->nullable();
            $table->integer('biaya_pengiriman')->default(0);
            $table->enum('status', ['menunggu', 'dikirim', 'terkirim'])->default('menunggu');
            $table->string('nama_kurir')->nullable();
            $table->timestamp('terkirim_pada')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengantarans');
    }
};
