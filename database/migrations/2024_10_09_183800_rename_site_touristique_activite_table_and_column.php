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
        // Renommer la table
        Schema::rename('site_touristique_activite', 'excursion_activite');

        // Renommer la colonne dans la nouvelle table
        Schema::table('excursion_activite', function (Blueprint $table) {
            $table->renameColumn('site_touristique_id', 'excursion_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revenir à l'ancienne table et colonne si on rollback la migration
        Schema::rename('excursion_activite', 'site_touristique_activite');

        Schema::table('site_touristique_activite', function (Blueprint $table) {
            $table->renameColumn('excursion_id', 'site_touristique_id');
        });
    }
};
