<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Encuentro
 * 
 * @property int $id
 * @property int $disciplina_id
 * @property int $categorias_equipo_id
 * @property int $campeonato_id
 * @property int|null $equipo_id
 * @property int|null $visita_id
 * @property Carbon|null $fecha
 * @property string|null $hora
 * @property string $estado_encuentro
 * @property string $etapa
 * @property int $empate
 * @property int $num_penales
 * @property int|null $score_local
 * @property int|null $score_visita
 * @property int $v_rojas
 * @property int $v_amarillas
 * @property int $v_faltas
 * @property int $l_rojas
 * @property int $l_amarillas
 * @property int $l_faltas
 * @property int $v_ganador
 * @property int $l_ganador
 * @property int $pto_score_local
 * @property int $pto_score_visita
 * @property int $l_penales
 * @property int $v_penales
 * @property string|null $v_codigo
 * @property string|null $l_codigo
 * @property string $estado
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property CategoriasEquipo $categorias_equipo
 * @property Disciplina $disciplina
 * @property Equipo|null $equipo
 *
 * @package App\Models
 */
class Encuentro extends Model
{
	use SoftDeletes;
	protected $table = 'encuentros';

	protected $casts = [
		'disciplina_id' => 'int',
		'categorias_equipo_id' => 'int',
		'campeonato_id' => 'int',
		'equipo_id' => 'int',
		'visita_id' => 'int',
		'fecha' => 'datetime',
		'empate' => 'int',
		'num_penales' => 'int',
		'score_local' => 'int',
		'score_visita' => 'int',
		'v_rojas' => 'int',
		'v_amarillas' => 'int',
		'v_faltas' => 'int',
		'l_rojas' => 'int',
		'l_amarillas' => 'int',
		'l_faltas' => 'int',
		'v_ganador' => 'int',
		'l_ganador' => 'int',
		'pto_score_local' => 'int',
		'pto_score_visita' => 'int',
		'l_penales' => 'int',
		'v_penales' => 'int'
	];

	protected $fillable = [
		'disciplina_id',
		'categorias_equipo_id',
		'campeonato_id',
		'equipo_id',
		'visita_id',
		'fecha',
		'hora',
		'estado_encuentro',
		'etapa',
		'empate',
		'num_penales',
		'score_local',
		'score_visita',
		'v_rojas',
		'v_amarillas',
		'v_faltas',
		'l_rojas',
		'l_amarillas',
		'l_faltas',
		'v_ganador',
		'l_ganador',
		'pto_score_local',
		'pto_score_visita',
		'l_penales',
		'v_penales',
		'v_codigo',
		'l_codigo',
		'estado'
	];

	public function categorias_equipo()
	{
		return $this->belongsTo(CategoriasEquipo::class);
	}

	public function disciplina()
	{
		return $this->belongsTo(Disciplina::class);
	}

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }

    public function visita()
    {
        return $this->belongsTo(Equipo::class, 'visita_id');
    }

    public function getEquipo($id)
    {
        $info=Infoequipo::where('equipo_id',$id)->first();
        $salida=null;
        if($info){
            $salida=$info->nombre;
        }
        return$salida;
    }
}
