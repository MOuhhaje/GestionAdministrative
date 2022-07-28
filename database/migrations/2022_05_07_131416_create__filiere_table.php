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
        Schema::create('Filieres', function (Blueprint $table) {
            $table->id('id');
            $table->string('Nom');
            $table->mediumText('Description');
            $table->string('Image')->default('filiere.png');
            $table->integer('Capacite')->unsigned();
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
        Schema::dropIfExists('Filiere');
    }
};
