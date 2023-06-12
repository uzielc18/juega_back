<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class Equipojugadore
 * 
 * @property int $id
 * @property int|null $infoequipo_id
 * @property string|null $nombres
 * @property string|null $apellidos
 * @property int|null $dni
 * @property int|null $foto
 * @property int|null $numero
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Equipojugadore extends Model
{
	protected $table = 'equipojugadores';

	protected $casts = [
		'infoequipo_id' => 'int',
		'dni' => 'int',
		'foto' => 'int',
		'numero' => 'int'
	];

	protected $fillable = [
		'infoequipo_id',
		'nombres',
		'apellidos',
		'dni',
		'foto',
		'numero'
	];
    protected $appends = [
        'photo_url',
    ];

    public function getPhotoUrlAttribute($value): string
    {
        if($value == NULL AND $this->codigo!==NULL AND $this->photo!==NULL) {
            $s3 = Storage::disk('s3');
            $s3Client = $s3->getDriver()->getAdapter()->getClient();
            $expiry = '+1440 minutes'; //firma la url del la imagen por 120 minutos
            $directory='upeu/users/'.$this->codigo;
            $type = 'GetObject';
            $cmd = $s3Client->getCommand($type, [
                'Bucket' => config('filesystems.disks.s3.bucket'),
                'Key'    => "$this->photo"
            ]);
            $request = $s3Client->createPresignedRequest($cmd, $expiry);
            //dd($request);
            return (string)$request->getUri();
        }else{
            return 'https://ui-avatars.com/api/?name='.$this->nombres.'&color=7F9CF5&background=EBF4FF';
        }
    }
    public function infoequipo()
    {
        return $this->belongsTo(Infoequipo::class);
    }
}
