<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Campeonato
 * 
 * @property int $id
 * @property string|null $name
 * @property string|null $logo
 * @property string|null $lema
 * @property string|null $pagina_web
 * @property Carbon|null $fecha_inicio
 * @property Carbon|null $fecha_fin
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Campeonato extends Model
{
	use SoftDeletes;
	protected $table = 'campeonatos';

	protected $casts = [
		'fecha_inicio' => 'datetime',
		'fecha_fin' => 'datetime'
	];

	protected $fillable = [
		'name',
		'logo',
		'lema',
		'pagina_web',
		'fecha_inicio',
		'fecha_fin'
	];
    public function disciplinas()
{
    return $this->hasMany(Disciplina::class);
}
}
