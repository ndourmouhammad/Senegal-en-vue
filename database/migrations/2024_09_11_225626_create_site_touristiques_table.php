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
        Schema::create('site_touristiques', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('description');
            $table->string('contenu');
            $table->time('heure_ouverture');
            $table->time('heure_fermeture');
            $table->integer('tarif_entree');
            // cle etrangere de activites
            $table->foreignId('activite_id')->constrained('activites')->onDelete('cascade')->onUpdate('cascade');
            // cle etrangere de regions
            $table->foreignId('region_id')->constrained('regions')->onDelete('cascade')->onUpdate('cascade');
            // cle etrangere de user
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_touristiques', function (Blueprint $table) {
            $table->dropForeign(['activite_id']);
        });
        
        Schema::dropIfExists('site_touristiques');
    }
};
