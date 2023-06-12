<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultadoResource extends JsonResource
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
 			'campeonato_id' => $this->campeonato_id, 
 			'disciplina_id' => $this->disciplina_id, 
 			'categorias_equipo_id' => $this->categorias_equipo_id, 
 			'equipo_id' => $this->equipo_id, 
 			'grupo' => $this->grupo, 
 			'name' => $this->name, 
 			'pj' => $this->pj, 
 			'pg' => $this->pg, 
 			'pp' => $this->pp, 
 			'pe' => $this->pe, 
 			'pf' => $this->pf, 
 			'pc' => $this->pc, 
 			'nf' => $this->nf, 
 			'tr' => $this->tr, 
 			'ta' => $this->ta, 
 			'pts' => $this->pts, 
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
