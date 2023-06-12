<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EtapaResource extends JsonResource
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
 			'campeonato_id' => $this->campeonato_id, 
 			'name' => $this->name, 
 			'fecha_inicio' => $this->fecha_inicio, 
 			'fecha_fin' => $this->fecha_fin, 
 			'n_encuentros' => $this->n_encuentros, 
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
