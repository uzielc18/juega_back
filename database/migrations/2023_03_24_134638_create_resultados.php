<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campeonato_id');
            $table->foreignId('disciplina_id');
            $table->foreignId('categorias_equipo_id');
            $table->foreignId('equipo_id');
            $table->string('grupo');
            $table->string('name')->nullable();
            $table->smallInteger('pj')->default(0);
            $table->smallInteger('pg')->default(0);
            $table->smallInteger('pp')->default(0);
            $table->smallInteger('pe')->default(0);
            $table->smallInteger('pf')->default(0);
            $table->smallInteger('pc')->default(0);
            $table->smallInteger('nf')->default(0);
            $table->smallInteger('tr')->default(0);
            $table->smallInteger('ta')->default(0);
            $table->smallInteger('pts')->default(0);
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
        Schema::dropIfExists('resultados');
    }
}
