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
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id();
            $table->string('contenu');
            // cle etrangere de users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            // cle etrangere de articles
            $table->foreignId('article_id')->constrained('articles')->onDelete('cascade')->onUpdate('cascade');
            $table->date('date_publication');
            $table->time('heure_publication');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commentaires', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['article_id']);
        });
        Schema::dropIfExists('commentaires');
    }
};
