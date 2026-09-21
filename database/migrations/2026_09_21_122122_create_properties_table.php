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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ex: "Villa Arty Riviera"
            $table->string('slug')->unique(); // Pour les URLs propres
            $table->text('short_description')->nullable(); // Accroche marketing
            $table->decimal('base_price', 10, 2)->default(0); // Prix par nuit
            $table->string('main_image')->nullable(); // Chemin de l'image principale
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
