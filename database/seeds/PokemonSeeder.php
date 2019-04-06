<?php

use Illuminate\Database\Seeder;

class PokemonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Import the all Pokemon species from PokeAPI
        $json = json_decode(file_get_contents('https://pokeapi.co/api/v2/pokemon-species?limit=1000'));

        foreach($json->results as $pokemon) {
            $splitString = explode('/', $pokemon->url);
            $pokemonId = $splitString[6];

            DB::table('pokemon')->insert([
                'pokemon_id' => $pokemonId,
                'name' => $pokemon->name,
            ]);
        }

        // Import all the Pokemon types from PokeAPI
        $json = json_decode(file_get_contents('https://pokeapi.co/api/v2/type?limit=20'));

        foreach($json->results as $type) {

            DB::table('types')->insert([
                'name' => $type->name,
            ]);
        }
    }
}
