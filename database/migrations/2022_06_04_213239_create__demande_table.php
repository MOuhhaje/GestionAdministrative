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
        Schema::create('Demandes', function (Blueprint $table) {
            $table->id();
            $table->enum('Role', array('Etudiant', 'Enseignant'));
            $table->enum('Status', array('Confirme', 'Refuse','En attant'))->default('En attant');
            $table->bigInteger('id_P')->unsigned()->nullable();
            $table->foreign('id_P')->references('id')->on('Enseignants')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('id_E')->unsigned()->nullable();
            $table->foreign('id_E')->references('id')->on('Etudiants')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('Demandes');
    }
};
