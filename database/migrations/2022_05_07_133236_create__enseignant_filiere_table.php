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
        Schema::create('Enseignant_Filieres', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('id_P')->unsigned();
            $table->bigInteger('id_F')->unsigned();
            $table->string('Module');
            $table->double('Heures');
            $table->foreign('id_F')->references('id')->on('Filieres')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_P')->references('id')->on('Enseignants')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('Prof_Filiere');
    }
};
