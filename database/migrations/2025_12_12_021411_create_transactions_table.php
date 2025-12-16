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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Peserta
            $table->foreignId('event_id')->constrained()->onDelete('cascade'); // Event
            $table->date('transaction_date');
            $table->string('payment_proof')->nullable(); // Bukti transfer
            
            // Status bayar: 'pending', 'confirmed', 'rejected'
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->decimal('total_price', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
