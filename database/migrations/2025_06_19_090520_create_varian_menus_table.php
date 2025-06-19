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
        Schema::create('varian_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_menu')->constrained('daftar_menu')->onDelete('cascade');
            $table->string('nama_varian'); // Contoh: Panas, Dingin, Original
            $table->decimal('harga', 10, 2);
            $table->boolean('tersedia')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('varian_menus');
    }
};
