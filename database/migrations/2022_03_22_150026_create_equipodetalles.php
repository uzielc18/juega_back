<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipodetalles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipojugadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('infoequipo_id')->nullable();
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->tinyInteger('dni')->nullable();
            $table->tinyInteger('foto')->nullable();
            $table->tinyInteger('numero')->nullable();
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
        Schema::dropIfExists('equipojugadores');
    }
}
