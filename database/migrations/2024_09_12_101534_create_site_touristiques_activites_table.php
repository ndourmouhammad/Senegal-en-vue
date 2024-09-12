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
        Schema::create('site_touristique_activite', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_touristique_id');  // Clé étrangère vers sites touristiques
            $table->unsignedBigInteger('activite_id');  // Clé étrangère vers activités
            $table->foreign('site_touristique_id')->references('id')->on('site_touristiques')->onDelete('cascade');
            $table->foreign('activite_id')->references('id')->on('activites')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_touristique_activite');
    }
};
