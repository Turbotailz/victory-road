<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePokemonTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pokemon_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pokemon_id')->unsigned();
            $table->bigInteger('type_id')->unsigned();
        });

        Schema::table('pokemon_type', function (Blueprint $table) {
            $table->foreign('pokemon_id')->references('id')->on('pokemon');
            $table->foreign('type_id')->references('id')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pokemon_type');
    }
}
