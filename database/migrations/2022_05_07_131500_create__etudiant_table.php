<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('Etudiants', function (Blueprint $table) {
            $table->id('id')->startingValue(19201);
            $table->string('Nom')->nullable();
            $table->string('Prenom')->nullable();
            $table->date('Naissance')->nullable();	
            $table->string('CIN')->unique()->nullable();
            $table->string('Email')->unique();
            $table->string('Adresse')->nullable();
            $table->string('Image')->default('noprofile.png');
            $table->bigInteger('Apogee')->nullable();
            $table->enum('Genre', array('Male', 'Femelle'))->nullable();
            $table->enum('Niveau', array('1èr année', '2ème année'))->default('1èr année');
            $table->bigInteger('F_ID')->unsigned()->nullable();
            $table->string('Username')->unique();
            $table->string('Password');
            $table->foreign('F_ID')->references('id')->on('Filieres')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('Etudiant');
    }
};
