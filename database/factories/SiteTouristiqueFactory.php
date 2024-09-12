<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SiteTouristique>
 */
class SiteTouristiqueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'libelle' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'contenu' => $this->faker->url,
            'heure_ouverture' => $this->faker->time,
            'heure_fermeture' => $this->faker->time,
            'tarif_entree' => $this->faker->randomNumber(),
            'activite_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}
