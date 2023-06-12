<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $updated_token
 * @property string|null $social_id
 * @property string|null $social_type
 * @property string|null $usuario_upeu
 * @property string|null $id_persona
 * @property string|null $facebook_id
 * @property string|null $linkedin_id
 * @property string|null $twitter_id
 * @property string|null token_refresh
 * @property string|null $correo_upeu
 * @property string|null $correo_externo
 * @property int|null $usuario_temporal
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    //use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;



    protected $table = 'users';

    protected $casts = [
        'current_team_id' => 'int',
        'email_verified_at' => 'datetime',
        'updated_token' => 'datetime'
    ];

    protected $dates = [
        'email_verified_at'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */

    protected $hidden = [
        'password',
        'two_factor_secret',
        'remember_token',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
        'current_team_id',
        'profile_photo_path',
        'social_id',
        'social_type',
        'usuario_upeu',
        'id_persona',
        'facebook_id',
        'linkedin_id',
        'twitter_id',
        'timezone',
        'lang',
        'updated_token',
        'token_refresh',
        'correo_upeu',
        'correo_externo',
        'usuario_temporal'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
    public function getProfilePhotoPathAttribute($value){
        if($value !== NULL) {
            if (preg_match('#^(https?://|www\.)#i', $value) === 1){
                return (string)$value;
            } else {
                $s3 = Storage::disk('s3');
                $s3Client = $s3->getDriver()->getAdapter()->getClient();
                $expiry = '+1440 minutes'; //firma la url del la imagen por 120 minutos
                $directory='upeu/users/'.$this->person->codigo;
                $type = 'GetObject';
                $cmd = $s3Client->getCommand($type, [
                    'Bucket' => config('filesystems.disks.s3.bucket'),
                    'Key'    => "$directory/$value"
                ]);
                $request = $s3Client->createPresignedRequest($cmd, $expiry);
                //dd($request);
                return (string)$request->getUri();
            }
        }
    }

    public function getProfilePhotoUrlAttribute(){
        if($this->profile_photo_path !== NULL) {
            return $this->profile_photo_path;
        }else{
            return 'https://ui-avatars.com/api/?name='.$this->name.'&color=7F9CF5&background=EBF4FF';
        }
    }
}
