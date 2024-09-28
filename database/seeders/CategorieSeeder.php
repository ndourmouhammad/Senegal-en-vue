<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Créer des catégories par défaut
        Categorie::create([
            'nom' => 'Musique',
            'description' => 'Concerts, festivals, et autres événements musicaux.'
        ]);

        Categorie::create([
            'nom' => 'Art',
            'description' => 'Expositions, galeries, et événements artistiques.'
        ]);

        Categorie::create([
            'nom' => 'Sport',
            'description' => 'Compétitions sportives, matchs, et événements de fitness.'
        ]);

        Categorie::create([
            'nom' => 'Gastronomie',
            'description' => 'Dégustations, festivals culinaires, et autres événements gastronomiques.'
        ]);

        Categorie::create([
            'nom' => 'Culture',
            'description' => 'Événements culturels, pièces de théâtre, et films.'
        ]);
    }
}
