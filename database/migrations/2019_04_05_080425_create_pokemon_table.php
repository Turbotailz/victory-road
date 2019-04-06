<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePokemonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pokemon', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pokemon_id')->unique();
            $table->string('name')->unique();
            $table->integer('evolves_from_id')->nullable();
            $table->string('genus')->nullable();
            $table->text('flavor_text')->nullable();
            $table->string('generation')->nullable();
        });

        Schema::table('pokemon', function (Blueprint $table) {
            $table->foreign('evolves_from_id')->references('pokemon_id')->on('pokemon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pokemon');
    }
}
