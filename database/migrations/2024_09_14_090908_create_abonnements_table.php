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
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('touriste_id')->constrained('users')->onDelete('cascade'); // Référence à l'utilisateur touriste
            $table->foreignId('guide_id')->constrained('users')->onDelete('cascade');   // Référence à l'utilisateur guide
            $table->enum('status', ['en cours', 'accepte', 'rejete'])->default('en cours');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Suppression de la table
        Schema::dropIfExists('abonnements');
    }
};
