<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create('fr_FR'); // Utilisation de l'ensemble de données francophones
        
        // Préfixes pour les numéros de téléphone au Sénégal
        $telephonePrefixes = ['77', '78', '70', '76', '75'];

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'genre' => $faker->randomElement(['Homme', 'Femme']),
                'date_naissance' => $faker->date('Y-m-d', '2000-01-01'),
                'telephone' => $faker->numerify('77#######'), // Numéro de téléphone réaliste
                'password' => Hash::make('password'),
                'adresse' => $faker->address(),
                'photo_profil' => $faker->imageUrl(640, 480, 'people'),
                'note' => $faker->numberBetween(1, 5),
                'langues' => $faker->randomElement(['français', 'anglais', 'wolof']),
                'numero_carte_guide' => $faker->numberBetween(100000, 999999),
                'carte_guide' => $faker->randomElement([1, 0]),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            
        }
    }
}
