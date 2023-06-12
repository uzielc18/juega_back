<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoequipos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infoequipos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->nullable();
            $table->foreignId('categorias_equipo_id')->nullable();
            $table->foreignId('disciplina_id')->nullable();
            $table->string('nombre')->nullable();
            $table->string('codigo')->nullable();
            $table->char('estado',1)->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('infoequipos');
    }
}
