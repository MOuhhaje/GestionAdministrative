<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Agents', function (Blueprint $table) {
            $table->id('id');
            $table->string('Nom')->nullable();
            $table->string('Prenom')->nullable();
            $table->string('CIN')->unique()->nullable();
            $table->string('Email')->unique()->nullable();
            $table->string('Adresse')->unique()->nullable();
            $table->string('img')->default('noprofile.png');
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
        Schema::dropIfExists('Agent');
    }
};
