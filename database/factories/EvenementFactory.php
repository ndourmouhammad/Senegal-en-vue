<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evenement>
 */
class EvenementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl,
            'date_debut' => $this->faker->date,
            'date_fin' => $this->faker->date,
            'nombre_participant' => $this->faker->randomNumber(),
            'prix' => $this->faker->randomNumber(),
            'category_id' => $this->faker->numberBetween(1, 5),
            'site_touristique_id' => $this->faker->numberBetween(3, 7)
        ];
    }
}
