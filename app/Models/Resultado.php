<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Resultado
 * 
 * @property int $id
 * @property int $campeonato_id
 * @property int $disciplina_id
 * @property int $categorias_equipo_id
 * @property int $equipo_id
 * @property string $grupo
 * @property string|null $name
 * @property int $pj
 * @property int $pg
 * @property int $pp
 * @property int $pe
 * @property int $pf
 * @property int $pc
 * @property int $nf
 * @property int $tr
 * @property int $ta
 * @property int $pts
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Resultado extends Model
{
	use SoftDeletes;
	protected $table = 'resultados';

	protected $casts = [
		'campeonato_id' => 'int',
		'disciplina_id' => 'int',
		'categorias_equipo_id' => 'int',
		'equipo_id' => 'int',
		'pj' => 'int',
		'pg' => 'int',
		'pp' => 'int',
		'pe' => 'int',
		'pf' => 'int',
		'pc' => 'int',
		'nf' => 'int',
		'tr' => 'int',
		'ta' => 'int',
		'pts' => 'int'
	];

	protected $fillable = [
		'campeonato_id',
		'disciplina_id',
		'categorias_equipo_id',
		'equipo_id',
		'grupo',
		'name',
		'pj',
		'pg',
		'pp',
		'pe',
		'pf',
		'pc',
		'nf',
		'tr',
		'ta',
		'pts'
	];
}
