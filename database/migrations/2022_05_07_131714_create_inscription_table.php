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
        Schema::create('Inscriptions', function (Blueprint $table) {
            $table->id('id');
            $table->string('Nom');
            $table->string('Prenom');
            $table->string('CIN')->unique();
            $table->string('Email')->unique();
            $table->date('Naissance');	
            $table->string('Genre');
            $table->string('Adresse');
            $table->enum('Status', array('Confirme', 'Refuse','En attant'))->default('En attant');
            $table->bigInteger('F_ID')->unsigned();
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
        Schema::dropIfExists('Inscription');
    }
};
