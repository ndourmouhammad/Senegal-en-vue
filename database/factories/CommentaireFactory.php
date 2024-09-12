<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commentaire>
 */
class CommentaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contenu' => $this->faker->paragraph,
            'date_publication' => $this->faker->date,
            'heure_publication' => $this->faker->time,
            'user_id' => $this->faker->numberBetween(1, 5),
            'article_id' => $this->faker->numberBetween(1, 5)
        ];
    }
}
