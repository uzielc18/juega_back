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
 * Class CategoriasEquipo
 * 
 * @property int $id
 * @property int $campeonato_id
 * @property string|null $name
 * @property string $estado
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Encuentro[] $encuentros
 * @property Collection|Equipo[] $equipos
 * @property Campeonato $campeonato
 *
 * @package App\Models
 */
class CategoriasEquipo extends Model
{
	use SoftDeletes;
	protected $table = 'categorias_equipos';

	protected $casts = [
		'campeonato_id' => 'int'
	];

	protected $fillable = [
		'campeonato_id',
		'name',
		'estado'
	];

	public function encuentros()
	{
		return $this->hasMany(Encuentro::class);
	}

    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    public function campeonato()
    {
        return $this->belongsTo(Campeonato::class);
    }
}
