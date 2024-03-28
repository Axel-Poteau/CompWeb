<?php

namespace Database\Seeders;

use App\Models\Activite;
use App\Models\Client;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class
AvisSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        //$clientHttp = new \GuzzleHttp\Client(['base_uri' => 'https://jaspervdj.be/lorem-markdownum/']);
        $faker = Factory::create('fr_FR');
        $activites = Activite::all();
        $client_ids = Client::all()->pluck('id');
        foreach ($activites as $activite) {
            $nbClients = $faker->numberBetween(2, max(5,count($client_ids)/2));
            $clients_avis_ids = $faker->randomElements($client_ids, $nbClients, false);
            $first = true;
            foreach ($clients_avis_ids as $id) {
                $note = $faker->numberBetween(0,5);
                $created_at = $faker->dateTimeInInterval(
                    '-3 months',
                    '+ 80 days',
                    date_default_timezone_get());
                $activite->clients()->attach($id, [
                    'note' => $note,
                    'commentaire' =>"x=coucou",
                    'created_at' => $created_at,
                    'updated_at' => $faker->dateTimeInInterval($created_at,
                        '+ 10 days', date_default_timezone_get())
                ]);
            }
        }

    }
}
