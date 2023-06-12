<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncuentros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuentros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disciplina_id')->constrained();
            $table->foreignId('categorias_equipo_id')->constrained();
            $table->foreignId('campeonato_id');
            $table->foreignId('equipo_id')->nullable()->constrained();
            $table->foreignId('visita_id')->nullable()->constrained('equipos','id');
            $table->date('fecha')->nullable();
            $table->string('hora')->nullable();
            $table->string('estado_encuentro')->default('pendiente');
            $table->enum('etapa',['grupos','octavos','cuartos','semifinales','finales','final'])->default('grupos');
            $table->tinyInteger('empate')->default(0);
            $table->tinyInteger('num_penales')->default(0);
            $table->tinyInteger('score_local')->nullable();
            $table->tinyInteger('score_visita')->nullable();
            $table->tinyInteger('v_rojas')->default(0);
            $table->tinyInteger('v_amarillas')->default(0);
            $table->tinyInteger('v_faltas')->default(0);
            $table->tinyInteger('l_rojas')->default(0);
            $table->tinyInteger('l_amarillas')->default(0);
            $table->tinyInteger('l_faltas')->default(0);
            $table->tinyInteger('v_ganador')->default(0);
            $table->tinyInteger('l_ganador')->default(0);
            $table->tinyInteger('pto_score_local')->default(0);
            $table->tinyInteger('pto_score_visita')->default(0);
            $table->tinyInteger('l_penales')->default(0);
            $table->tinyInteger('v_penales')->default(0);
            $table->char('v_codigo',3)->nullable()
                ->comment('Letra del Grupo A,B,D Posición en la tabla 1,2,3 ejem D-1');
            $table->char('l_codigo',3)->nullable()
                ->comment('Letra del Grupo A,B,D Posición en la tabla 1,2,3 ejem D-2');
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
        Schema::dropIfExists('encuentros');
    }
}
