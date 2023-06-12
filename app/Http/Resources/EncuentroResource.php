<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EncuentroResource extends JsonResource
{
    /**
     * @var null
     */
    protected $message = null;

    /**
     * @param $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id, 
 			'disciplina_id' => $this->disciplina_id, 
 			'categorias_equipo_id' => $this->categorias_equipo_id, 
 			'campeonato_id' => $this->campeonato_id, 
 			'equipo_id' => $this->equipo_id, 
 			'visita_id' => $this->visita_id, 
 			'fecha' => $this->fecha, 
 			'hora' => $this->hora, 
 			'estado_encuentro' => $this->estado_encuentro, 
 			'etapa' => $this->etapa, 
 			'empate' => $this->empate, 
 			'num_penales' => $this->num_penales, 
 			'score_local' => $this->score_local, 
 			'score_visita' => $this->score_visita, 
 			'v_rojas' => $this->v_rojas, 
 			'v_amarillas' => $this->v_amarillas, 
 			'v_faltas' => $this->v_faltas, 
 			'l_rojas' => $this->l_rojas, 
 			'l_amarillas' => $this->l_amarillas, 
 			'l_faltas' => $this->l_faltas, 
 			'v_ganador' => $this->v_ganador, 
 			'l_ganador' => $this->l_ganador, 
 			'pto_score_local' => $this->pto_score_local, 
 			'pto_score_visita' => $this->pto_score_visita, 
 			'l_penales' => $this->l_penales, 
 			'v_penales' => $this->v_penales, 
 			'v_codigo' => $this->v_codigo, 
 			'l_codigo' => $this->l_codigo, 
 			'estado' => $this->estado, 
 			'deleted_at' => $this->deleted_at, 
 			'created_at' => $this->created_at, 
 			'updated_at' => $this->updated_at, 
 			
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request $request
     * @return array
     */
    public function with($request)
    {
        return [
            'success' => true,
            'message' => $this->message,
            'meta' => null,
            'errors' => null
        ];
    }
}
