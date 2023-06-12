<?php

namespace App\Observers;

use App\Models\Encuentro;
use App\Models\Resultado;

class EncuentroObserver
{
    public $afterCommit = false;

    /**
     * Handle the Encuentro "created" event.
     *
     * @param  \App\Models\Encuentro  $encuentro
     *
     * @return void
     */
    public function created(Encuentro $encuentro)
    {
        //
    }
    /**
     * Handle the Encuentro "updated" event.
     *
     * @param  \App\Models\Encuentro  $encuentro
     *
     * @return void
     */
    public function updating(Encuentro $encuentro)
    {
        if ($encuentro->score_equipo > $encuentro->score_rival) {
            $encuentro->e_ganador = 1;
            $encuentro->r_ganador = 0;
            $encuentro->empate = 0;
        }
        if ($encuentro->score_equipo == $encuentro->score_rival) {
            $encuentro->e_ganador = 0;
            $encuentro->r_ganador = 0;
            $encuentro->empate = 1;
        }
        if ($encuentro->score_equipo < $encuentro->score_rival) {
            $encuentro->e_ganador = 0;
            $encuentro->r_ganador = 1;
            $encuentro->empate = 0;
        }

        if ($encuentro->e_penales < $encuentro->r_penales) {
            $encuentro->e_ganador = 0;
            $encuentro->r_ganador = 1;
            $encuentro->empate = 0;
        }

        if ($encuentro->e_penales > $encuentro->r_penales) {
            $encuentro->e_ganador = 1;
            $encuentro->r_ganador = 0;
            $encuentro->empate = 0;
        }

        if ($encuentro->estado_encuentro == 'finalizado') {
            $encuentro->e_p = $encuentro->e_p?:100;
            $encuentro->r_p = $encuentro->r_p?:100;
            $encuentro->e_u = $encuentro->e_u?:100;
            $encuentro->r_u = $encuentro->r_u?:100;
            $encuentro->r_c_d_j = $encuentro->r_c_d_j?:100;
            $encuentro->e_c_d_j = $encuentro->e_c_d_j?:100;
        }
        //
    }
    /**
     * Handle the Encuentro "updated" event.
     *
     * @param  \App\Models\Encuentro  $encuentro
     *
     * @return void
     */
    public function updated(Encuentro $encuentro)
    {
        try {
            //
            //$data = $encuentro->getDirty();

            if ($encuentro->estado_encuentro == 'encurso'
                or $encuentro->estado_encuentro == 'finalizado'
            ) {
                $local = $encuentro->equipo_id;
                $local_name = $encuentro->equipo?->name;
                $local_name .= ' '.$encuentro->getEquipo($encuentro->equipo_id);
                $e_l_e=explode('-',$encuentro->equipo?->codigo);
                $grupo_local =end($e_l_e);
                $visita = $encuentro->upeurival_id;
                $visita_name = $encuentro->upeurival?->name;
                $visita_name .= ' '.$encuentro->getEquipo($encuentro->upeurival_id);;
                $v_l_v=explode('-',$encuentro->equipo?->codigo);
                $grupo_visita =end($v_l_v);

                $campeonato_id
                    = $encuentro->equipo->campeonato_id;

                $disciplina_id
                    = $encuentro->equipo->disciplina_id;

                $categoria_equipo_id
                    = $encuentro->equipo->categoria_equipo_id;

                $A_local_resultados = Encuentro::where('equipo_id','=',
                    $local)
                    ->where('etapa','=','grupos')
                    ->where('estado_encuentro', '!=', 'pendiente')->get();

                $A_visita_resultados = Encuentro::where('upeurival_id',
                    $local)
                    ->where('etapa', 'grupos')
                    ->where('estado_encuentro', '!=', 'pendiente')->get();

                $A_empate = ($A_local_resultados->sum('empate')
                    + $A_visita_resultados->sum('empate'));
                $A_ganador = ($A_local_resultados->sum('e_ganador')
                    + $A_visita_resultados->sum('r_ganador'));
                $A_perdio = ($A_local_resultados->where('empate', 0)
                        ->where('e_ganador', 0)->count('id')
                    + $A_visita_resultados->where('empate', 0)
                        ->where('r_ganador', 0)
                        ->count('id'));
                $A_score_equipo = $A_local_resultados->sum('score_equipo')
                    + $A_visita_resultados->sum('score_rival');
                $A_score_encontra_equipo
                    = $A_local_resultados->sum('score_rival')
                    + $A_visita_resultados->sum('score_equipo');

                $A_rojas = ($A_local_resultados->sum('e_rojas')
                    + $A_visita_resultados->sum('r_rojas'));

                $A_amarillas = ($A_local_resultados->sum('e_amarillas')
                    + $A_visita_resultados->sum('r_amarillas'));

                $A_faltas = ($A_local_resultados->sum('e_faltas')
                    + $A_visita_resultados->sum('r_faltas'));

                $pts_A= ($A_ganador * 3) + ($A_empate
                        * 1);

                if($encuentro->equipo->upeudisciplina->name=='VOLEY'){
                    /* Partidos 2 a 0 a 3 puntos al ganador */
                    /* Partidos 2 a 1 a 2 puntos al ganador y un punto al ganador */
                    $A_pts3=($A_local_resultados->where('score_equipo',2)->where('score_rival',0)->sum('e_ganador')
                            + $A_visita_resultados->where('score_equipo',0)->where('score_rival',2)->sum('r_ganador'))*3;
                    $A_pts2=($A_local_resultados->where('score_equipo',2)->where('score_rival',1)->sum('e_ganador')
                            + $A_visita_resultados->where('score_equipo',1)->where('score_rival',2)->sum('r_ganador'))*2;
                    $A_pts1 = ($A_local_resultados->where('empate', 0)
                            ->where('e_ganador', 0)->where('score_equipo',1)->count('id')
                        + $A_visita_resultados->where('empate', 0)
                            ->where('r_ganador', 0)->where('score_rival',1)
                            ->count('id'));

                    $pts_A=$A_pts3+$A_pts2+$A_pts1;
                }

                $B_local_resultados = Encuentro::where('equipo_id',
                    $visita)
                    ->where('etapa', 'grupos')
                    ->where('estado_encuentro', '!=', 'pendiente')->get();
                $B_visita_resultados = Encuentro::where('upeurival_id',
                    $visita)
                    ->where('etapa', 'grupos')
                    ->where('estado_encuentro', '!=', 'pendiente')->get();
                $B_empate = $B_local_resultados->sum('empate')
                    + $B_visita_resultados->sum('empate');
                $B_ganador = ($B_local_resultados->sum('e_ganador')
                    + $B_visita_resultados->sum('r_ganador'));
                $B_perdio = ($B_local_resultados->where('empate', 0)
                        ->where('e_ganador', 0)->count('id')
                    + $B_visita_resultados->where('empate', 0)
                        ->where('r_ganador', 0)
                        ->count('id'));;
                $B_score_equipo = ($B_local_resultados->sum('score_equipo')
                    + $B_visita_resultados->sum('score_rival'));
                $B_score_encontra_equipo
                    = ($B_local_resultados->sum('score_rival')
                    + $B_visita_resultados->sum('score_equipo'));
                $B_rojas = ($B_local_resultados->sum('e_rojas')
                    + $B_visita_resultados->sum('r_rojas'));
                $B_amarillas = ($B_local_resultados->sum('e_amarillas')
                    + $B_visita_resultados->sum('r_amarillas'));
                $B_faltas = ($B_local_resultados->sum('e_faltas')
                    + $B_visita_resultados->sum('r_faltas'));
                $pts_B = ($B_ganador * 3) + ($B_empate
                        * 1);
                if($encuentro->equipo->upeudisciplina->name=='VOLEY'){
                    /* Partidos 2 a 0 a 3 puntos al ganador */
                    /* Partidos 2 a 1 a 2 puntos al ganador y un punto al ganador */
                    $B_pts3=($B_local_resultados->where('score_equipo',2)->where('score_rival',0)->sum('e_ganador')
                            + $B_visita_resultados->where('score_equipo',0)->where('score_rival',2)->sum('r_ganador'))*3;
                    $B_pts2=($B_local_resultados->where('score_equipo',2)->where('score_rival',1)->sum('e_ganador')
                            + $B_visita_resultados->where('score_equipo',1)->where('score_rival',2)->sum('r_ganador'))*2;
                    $B_pts1 = ($B_local_resultados->where('empate', 0)
                            ->where('e_ganador', 0)->where('score_equipo',1)->count('id')
                        + $B_visita_resultados->where('empate', 0)
                            ->where('r_ganador', 0)->where('score_rival',1)
                            ->count('id'));

                    $pts_B=$B_pts3+$B_pts2+$B_pts1;
                }
                Resultado::updateOrCreate([
                    'equipo_id'            => $local,
                    'campeonato_id'        => $campeonato_id,
                    'disciplina_id'        => $disciplina_id,
                    'categoria_equipo_id' => $categoria_equipo_id,
                ], [
                    'campeonato_id'        => $campeonato_id,
                    'disciplina_id'        => $disciplina_id,
                    'categoria_equipo_id' => $categoria_equipo_id,
                    'equipo_id'            => $local,
                    'grupo'            => $grupo_local,
                    'pj'                       => $A_ganador + $A_empate
                        + $A_perdio,
                    'pg'                       => $A_ganador,
                    'pp'                       => $A_perdio,
                    'pe'                       => $A_empate,
                    'pf'                       => $A_score_equipo,
                    'pc'                       => $A_score_encontra_equipo,
                    'nf'                       => $A_faltas,
                    'tr'                       => $A_rojas,
                    'ta'                       => $A_amarillas,
                    'pts'                      => $pts_A,
                    'orden'                    => 0,
                    'name'=>$local_name
                ]);
                Resultado::updateOrCreate([
                    'equipo_id'            => $visita,
                    'campeonato_id'        => $campeonato_id,
                    'disciplina_id'        => $disciplina_id,
                    'categoria_equipo_id' => $categoria_equipo_id,
                ], [
                    'campeonato_id'        => $campeonato_id,
                    'disciplina_id'        => $disciplina_id,
                    'categoria_equipo_id' => $categoria_equipo_id,
                    'equipo_id'            => $visita,
                    'grupo'            => $grupo_visita,
                    'pj'                       => $B_ganador + $B_empate
                        + $B_perdio,
                    'pg'                       => $B_ganador,
                    'pp'                       => $B_perdio,
                    'pe'                       => $B_empate,
                    'pf'                       => $B_score_equipo,
                    'pc'                       => $B_score_encontra_equipo,
                    'nf'                       => $B_faltas,
                    'tr'                       => $B_rojas,
                    'ta'                       => $B_amarillas,
                    'pts'                      => $pts_B,
                    'orden'                    => 0,
                    'name'=>$visita_name
                ]);

            }


            if ($encuentro->estado_encuentro == 'finalizado') {
                $encuentro->e_p = $encuentro->e_p?:100;
                $encuentro->r_p = $encuentro->r_p?:100;
                $encuentro->e_u = $encuentro->e_u?:100;
                $encuentro->r_u = $encuentro->r_u?:100;
                $encuentro->r_c_d_j = $encuentro->r_c_d_j?:100;
                $encuentro->e_c_d_j = $encuentro->e_c_d_j?:100;
            }

        } catch (\Exception $e) {
            //dd($e);
            abort(500,$e);
        }

    }

    /**
     * Handle the Encuentro "deleted" event.
     *
     * @param  \App\Models\Encuentro  $encuentro
     *
     * @return void
     */
    public function deleted(Encuentro $encuentro)
    {
        //
    }

    /**
     * Handle the Encuentro "restored" event.
     *
     * @param  \App\Models\Encuentro  $encuentro
     *
     * @return void
     */
    public function restored(Encuentro $encuentro)
    {
        //
    }

    /**
     * Handle the Encuentro "force deleted" event.
     *
     * @param  \App\Models\Encuentro  $encuentro
     *
     * @return void
     */
    public function forceDeleted(Encuentro $encuentro)
    {
        //
    }
}
