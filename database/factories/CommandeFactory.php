<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commande>
 */
class CommandeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 5),
            'site_touristique_id' => $this->faker->numberBetween(3, 7),
            // statut en cours, termine, refuse
            'statut' => $this->faker->randomElement(['en cours', 'termine', 'refuse']),
            'date_commande' => $this->faker->date
        ];
    }
}
