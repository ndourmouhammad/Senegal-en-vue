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
        Schema::create('article_user_like', function (Blueprint $table) {
            $table->id();
            // Champs pour la relation avec user et article
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            // Le champ pour savoir si c'est un like ou dislike (boolean)
            $table->boolean('is_like'); 
            // Timestamps pour enregistrer la date de création et de mise à jour
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_user_like');
    }
};
