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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('evenement_id')->constrained('evenements')->onDelete('cascade')->onUpdate('cascade');
            $table->date('date_reservation');
            $table->time('heure_reservation');
            $table->enum('statut', ['en cours', 'termine', 'refuse'])->default('en cours');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['evenement_id']);
        });
        Schema::dropIfExists('reservations');
    }
};
