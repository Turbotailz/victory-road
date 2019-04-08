<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pokemon;
use App\Type;

class PokemonController extends Controller
{
    // Return a list of all Pokemon
    function getAllPokemon() {
        return Pokemon::all();
    }

    // Get a Pokemon and its data
    function getPokemon($id) {
        $pokemon = Pokemon::with(['evolvesFrom', 'evolvesTo'])->find($id);

        // Check if we have cached data for the requested Pokemon
        if ($pokemon) {
            // If there is no "generation" stored, it is assumed we haven't queried this Pokemon before
            if ($pokemon->generation) {
                return $pokemon;
            } else {
                // Fetch the Pokemon data and save it to the database
                $json = json_decode(file_get_contents('https://pokeapi.co/api/v2/pokemon-species/' . $pokemon->pokemon_id));

                $pokemon->generation = $json->generation->name;

                if ($json->evolves_from_species) {
                    $splitString = explode('/', $json->evolves_from_species->url);
                    $pokemonId = $splitString[6];

                    $pokemon->evolves_from_id = $pokemonId;
                }

                foreach($json->genera as $genus) {
                    if ($genus->language->name == 'en') {
                        $pokemon->genus = $genus->genus;
                    }
                }

                foreach($json->flavor_text_entries as $flavor_text) {
                    if ($flavor_text->language->name == 'en') {
                        $pokemon->flavor_text = $flavor_text->flavor_text;

                        break;
                    }
                }

                // Fire off another request to get the Pokemon's type data
                $json = json_decode(file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $pokemon->pokemon_id));

                $types = [];

                foreach ($json->types as $type) {
                    $pokemonType = Type::where('name', $type->type->name)->first()->id;
                    $types[] = $pokemonType;
                }

                $pokemon->types()->sync($types);

                $pokemon->save();

                // Returning $pokemon here won't return the saved data - maybe I'm missing something here but this solution works instead
                return Pokemon::with(['evolvesFrom', 'evolvesTo'])->find($id);
            }
        } else {
            return response(404);
        }
    }

    // Return a random Pokemon for the "Who's that Pokemon" quiz
    function getRandomPokemon() {
        $randomPokemonId = Pokemon::with(['evolvesFrom', 'evolvesTo'])->inRandomOrder()->first()->pokemon_id;

        return $this->getPokemon($randomPokemonId);
    }
}
