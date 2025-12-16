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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date('event_date');
            $table->string('location');
            $table->integer('quota'); // Jumlah kursi
            $table->decimal('price', 10, 2)->default(0); // 0 = Gratis
            $table->string('banner')->nullable(); // Foto poster
            
            // Relasi: Siapa EO yang buat? Kategori apa?
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // EO
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            
            // Status event: 'draft', 'published', 'closed'
            $table->enum('status', ['draft', 'published', 'closed'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
