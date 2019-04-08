<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $with = ['types'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    // Get the type(s) of the Pokemon
    public function types() {
        return $this->belongsToMany('App\Type');
    }

    // Get the Pokemon this Pokemon evolves from (if any)
    public function evolvesFrom() {
        return $this->hasOne('App\Pokemon', 'pokemon_id', 'evolves_from_id');
    }

    // Get the Pokemon this Pokemon evolves into (if any)
    public function evolvesTo() {
        return $this->belongsTo('App\Pokemon', 'pokemon_id', 'evolves_from_id');
    }
}
