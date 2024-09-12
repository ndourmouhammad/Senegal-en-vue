<?php

namespace Database\Seeders;

use App\Models\SiteTouristique;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteTouristiqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteTouristique::factory()->count(5)->create();
    }
}
