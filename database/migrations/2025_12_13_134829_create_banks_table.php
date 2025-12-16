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
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            // Kolom user_id (Milik Siapa?)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Data Bank
            $table->string('bank_name');      // Misal: BCA
            $table->string('account_number'); // Misal: 1234567890
            $table->string('account_holder'); // Misal: Panitia Event
            $table->string('logo')->nullable(); // Logo Bank
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
