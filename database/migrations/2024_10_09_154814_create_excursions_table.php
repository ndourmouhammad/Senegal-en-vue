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
        Schema::create('excursions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('libelle');
            $table->text('description');
            $table->string('contenu');
            $table->string('image');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('tarif_entree');
            $table->integer('nombre_participants');
            $table->foreignId('site_touristique_id')->constrained('site_touristiques')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('excursions', function (Blueprint $table) {
            $table->dropForeign(['site_touristique_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('excursions');
    }
};
