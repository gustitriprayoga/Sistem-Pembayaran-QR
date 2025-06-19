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
        Schema::create('daftar_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori_menus');
            $table->string('nama_menu');
            $table->text('deskripsi')->nullable();
            $table->string('url_gambar')->nullable();
            $table->boolean('tersedia')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_menus');
    }
};
