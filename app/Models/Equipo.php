<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Equipo
 * 
 * @property int $id
 * @property int $disciplina_id
 * @property int $categorias_equipo_id
 * @property int $campeonato_id
 * @property string $name
 * @property string $color
 * @property string $grupo
 * @property int $orden
 * @property string $estado
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property CategoriasEquipo $categorias_equipo
 * @property Disciplina $disciplina
 * @property Collection|Encuentro[] $encuentros_equipo
 * @property Collection|Encuentro[] $encuentros_visita
 *
 * @package App\Models
 */
class Equipo extends Model
{
	use SoftDeletes;
	protected $table = 'equipos';

	protected $casts = [
		'disciplina_id' => 'int',
		'categorias_equipo_id' => 'int',
		'campeonato_id' => 'int',
		'orden' => 'int'
	];

	protected $fillable = [
		'disciplina_id',
		'categorias_equipo_id',
		'campeonato_id',
		'name',
		'color',
		'grupo',
		'orden',
		'estado'
	];
    public function infoequipo()
    {
        return $this->hasOne(Infoequipo::class,'equipo_id','id');
    }
	public function categoriasEquipo()
	{
		return $this->belongsTo(CategoriasEquipo::class);
	}

	public function disciplina()
	{
		return $this->belongsTo(Disciplina::class);
	}

    public function encuentros_equipo()
    {
        return $this->hasMany(Encuentro::class, 'equipo_id');
    }

    public function encuentros_visita()
    {
        return $this->hasMany(Encuentro::class, 'visita_id');
    }
}
