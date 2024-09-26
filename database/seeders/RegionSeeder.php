<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            [
                'libelle' => 'Dakar',
                'description' => 'Capitale dynamique du Sénégal, connue pour son ambiance culturelle et historique. L’île de Gorée, site classé au patrimoine mondial, témoigne du passé colonial.',
                'superficie' => 85,
                'population' => 1140000,
            ],
            [
                'libelle' => 'Diourbel',
                'description' => 'Centre de la culture Mouride, célèbre pour son ambiance vibrante. Les célébrations religieuses et l’architecture de la ville attirent de nombreux visiteurs.',
                'superficie' => 12000,
                'population' => 400000,
            ],
            [
                'libelle' => 'Fatick',
                'description' => 'Région riche en traditions et histoire, Fatick est connue pour ses monuments historiques. Les visiteurs peuvent explorer ses sites culturels et ses festivals colorés.',
                'superficie' => 10200,
                'population' => 350000,
            ],
            [
                'libelle' => 'Kaffrine',
                'description' => 'Kaffrine, avec ses paysages variés, est un endroit idéal pour découvrir la vie rurale. La région est riche en traditions culturelles et en festivals.',
                'superficie' => 15000,
                'population' => 50000,
            ],
            [
                'libelle' => 'Kédougou',
                'description' => 'Kédougou est connue pour ses magnifiques paysages et sa biodiversité. C’est un lieu privilégié pour les amateurs de nature et d’aventure.',
                'superficie' => 30000,
                'population' => 80000,
            ],
            [
                'libelle' => 'Kaolack',
                'description' => 'Centre commercial important, Kaolack est renommée pour son marché d’arachides. La ville est un carrefour culturel et historique dans la région.',
                'superficie' => 13492,
                'population' => 450000,
            ],
            [
                'libelle' => 'Kolda',
                'description' => 'Kolda est riche en diversité ethnique et culturelle, avec de nombreuses traditions. La région est également connue pour sa faune et ses paysages pittoresques.',
                'superficie' => 30000,
                'population' => 300000,
            ],
            [
                'libelle' => 'Louga',
                'description' => 'Louga, fertile et agricole, est célèbre pour ses paysages naturels. Les festivals locaux et les traditions culturelles attirent de nombreux visiteurs.',
                'superficie' => 20000,
                'population' => 300000,
            ],
            [
                'libelle' => 'Matam',
                'description' => 'Matam est riche en ressources naturelles et en histoire. La région est un point de départ pour explorer la culture locale et la faune.',
                'superficie' => 13000,
                'population' => 200000,
            ],
            [
                'libelle' => 'Saint-Louis',
                'description' => 'Ville historique, Saint-Louis est classée au patrimoine mondial pour son architecture. Les festivals de musique et la proximité des parcs nationaux en font une destination prisée.',
                'superficie' => 20000,
                'population' => 200000,
            ],
            [
                'libelle' => 'Sédhiou',
                'description' => 'Sédhiou combine modernité et traditions, avec une riche culture locale. La région est connue pour ses paysages naturels et ses festivals culturels.',
                'superficie' => 4000,
                'population' => 150000,
            ],
            [
                'libelle' => 'Tambacounda',
                'description' => 'Région la plus vaste du Sénégal, Tambacounda est riche en biodiversité. C’est un lieu de choix pour les amoureux de la nature et des randonnées.',
                'superficie' => 73000,
                'population' => 80000,
            ],
            [
                'libelle' => 'Thiès',
                'description' => 'Thiès, connue pour son artisanat et ses festivals, offre une expérience culturelle unique. La ville est un centre de commerce et d’artisanat local.',
                'superficie' => 10200,
                'population' => 800000,
            ],
            [
                'libelle' => 'Ziguinchor',
                'description' => 'Capitale de la Casamance, Ziguinchor est réputée pour sa biodiversité et sa culture unique. Les visiteurs peuvent explorer ses paysages magnifiques et sa riche histoire.',
                'superficie' => 30000,
                'population' => 200000,
            ],
        ];

        // Insertion des données dans la table 'regions'
        DB::table('regions')->insert($regions);
    }
}
