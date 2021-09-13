<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->foreignId('team_1_id')->references('id')->on('teams')->cascadeOnUpdate();
            $table->foreignId('team_2_id')->references('id')->on('teams')->cascadeOnUpdate();
            $table->foreignId('division_id')->references('id')->on('divisions')->cascadeOnUpdate();
            $table->foreignId('tournament_id')->references('id')->on('tournaments')->cascadeOnUpdate();
            $table->foreignId('stadium_id')->references('id')->on('stadiums')->cascadeOnUpdate();
            $table->dateTime('started_at');
            $table->dateTime('finished_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
