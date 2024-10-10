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
        Schema::table('excursion_activite', function (Blueprint $table) {
            // Supprimer la clé étrangère
            $table->dropForeign('site_touristique_activite_site_touristique_id_foreign');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('excursion_activite', function (Blueprint $table) {
            //
        });
    }
};
