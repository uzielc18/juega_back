<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Http\Resources\EquipoCollection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Infoequipo
 * 
 * @property int $id
 * @property int|null $equipo_id
 * @property int|null $categorias_equipo_id
 * @property int|null $disciplina_id
 * @property string|null $nombre
 * @property string|null $codigo
 * @property string $estado
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Equipo $equipo
 * @property Disciplina $disciplina
 * @property CategoriasEquipo $categorias_equipo
 * @property Collection|Equipojugadore[] $equipojugadores
 *
 * @package App\Models
 */
class Infoequipo extends Model
{
	use SoftDeletes;
	protected $table = 'infoequipos';

	protected $casts = [
		'equipo_id' => 'int',
		'categorias_equipo_id' => 'int',
		'disciplina_id' => 'int'
	];

	protected $fillable = [
		'equipo_id',
		'categorias_equipo_id',
		'disciplina_id',
		'nombre',
		'codigo',
		'estado'
	];
    public function equipo()
    {
        return $this->belongsTo(Equipo::class,'equipo_id');
    }
    public function categorias_equipo()
    {
        return $this->belongsTo(CategoriasEquipo::class,'categorias_equipo_id');
    }
    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class,'disciplina_id');
    }

    public function equipojudaores()
    {
        return $this->hasMany(Equipojugadore::class);
    }
}
