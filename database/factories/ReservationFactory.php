<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_reservation' => $this->faker->date,
            'heure_reservation' => $this->faker->time,
            'user_id' => $this->faker->numberBetween(1, 5),
            'evenement_id' => $this->faker->numberBetween(1, 5),
            'statut' => $this->faker->randomElement(['en cours', 'termine', 'refuse']),
        ];
    }
}
