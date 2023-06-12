<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Etapa
 * 
 * @property int $id
 * @property int $disciplina_id
 * @property int $campeonato_id
 * @property string|null $name
 * @property Carbon|null $fecha_inicio
 * @property Carbon|null $fecha_fin
 * @property Carbon|null $n_encuentros
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Etapa extends Model
{
	use SoftDeletes;
	protected $table = 'etapas';

	protected $casts = [
		'disciplina_id' => 'int',
		'campeonato_id' => 'int',
		'fecha_inicio' => 'datetime',
		'fecha_fin' => 'datetime',
		'n_encuentros' => 'datetime'
	];

	protected $fillable = [
		'disciplina_id',
		'campeonato_id',
		'name',
		'fecha_inicio',
		'fecha_fin',
		'n_encuentros'
	];

    public function disciplina(){
        return $this->belongsTo(Disciplina::class);
    }
}
