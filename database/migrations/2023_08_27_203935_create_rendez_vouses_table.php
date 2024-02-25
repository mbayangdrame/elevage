<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRendezVousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rendez_vouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_eleveur');
            $table->unsignedBigInteger('id_veterinaire');
            $table->date("dateRendezVous");
            $table->string('Motif');
            $table->time('heure');
            $table->string('status')->default('en_attente');
            $table->foreign('id_eleveur')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_veterinaire')->references('id')->on('veterinaires')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rendez_vouses');
    }
}
