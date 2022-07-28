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
        Schema::create('Enseignants', function (Blueprint $table) {
            $table->id('id');
            $table->string('Nom')->nullable();
            $table->string('Prenom')->nullable();
            $table->string('CIN')->unique()->nullable();
            $table->string('Email')->unique()->nullable();
            $table->string('Image')->default('noprofile.png');
            $table->string('Adresse')->nullable();
            $table->string('Matricule')->unique();
            $table->string('Password');
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
        Schema::dropIfExists('Prof');
    }
};
