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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            // cle etrangere de users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            // cle etrangere de site_touristiques
            $table->foreignId('site_touristique_id')->constrained('site_touristiques')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('statut', ['en cours', 'termine', 'refuse'])->default('en cours');
            $table->date('date_commande');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['site_touristique_id']);
        });
        Schema::dropIfExists('commandes');
    }
};
