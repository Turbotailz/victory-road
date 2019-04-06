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

    public function types() {
        return $this->belongsToMany('App\Type');
    }

    public function evolvesFrom() {
        return $this->hasOne('App\Pokemon', 'pokemon_id', 'evolves_from_id');
    }

    public function evolvesTo() {
        return $this->belongsTo('App\Pokemon', 'pokemon_id', 'evolves_from_id');
    }
}
