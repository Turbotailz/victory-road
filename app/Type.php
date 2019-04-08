<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    // List the Pokemon with this type
    public function pokemon() {
        return $this->belongsToMany('App\Pokemon');
    }
}
