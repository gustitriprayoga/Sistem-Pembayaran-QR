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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');
            $table->string('order_code')->unique();
            $table->enum('status', ['pending', 'paid', 'processing', 'done'])->default('pending');
            $table->enum('payment_method', ['qris', 'e-wallet', 'bank_transfer', 'cod', 'cash'])->default('qris');
            $table->string('payment_channel')->nullable();
            $table->string('payment_reference')->nullable();
            $table->integer('total_price');
            $table->string('qr_code')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
