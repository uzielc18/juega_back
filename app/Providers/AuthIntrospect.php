<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Helpers\Helpers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AuthIntrospect
{
    public static function boot()
    {

        Auth::viaRequest('lamb-guard', function (Request $request) {
            if($request->is('api/*')){
                $user = self::getUser($request);
                //dd($user);
                return $user;
            }
        });
    }

    private static function getUser(Request $request)
    {
        $user = null;
        //abort(500,$request);
        $key = self::getStrategyName($request);
        if ($key == '_google_strategy') {
            [$userKey,$data] = self::getEmailGoogle($request);
            $user = User::where('social_type', 'google')->where('social_id', $userKey)->first();
            //dd($user,$userKey);
            if(!$user) {
                //dd('entro');
                self::newUsuarioGoogle($request);
                sleep(1);
                $user_nuevo = User::where('social_type', 'google')->where('social_id', $userKey)->first();
                $user_nuevo->person->Configuracion();
                $user=$user_nuevo;
                //abort(204, 'Usuario registrado Ingrese nuevamente sus credenciales');
                //sleep(1);
            }
        } elseif ($key == '_azure_strategy') {
            [$userKey,$data] = self::getEmailAzure($request);
            //dd($userKey);
            $user = User::where('microsoft_id', $userKey)->first();
            if(!$user) {
                self::newUsuarioAzure($request);
                sleep(1);
                $user_nuevo = User::where('microsoft_id', $userKey)->first();
                $user_nuevo->person->Configuracion();
                $user=$user_nuevo;
                //abort(204, 'Usuario registrado Ingrese nuevamente sus credenciales');
                //sleep(1);
            }
        } elseif ($key == 'email') {
            $access_token = $request->bearerToken();
            $model = Sanctum::$personalAccessTokenModel;
            $accessToken = $model::findToken($access_token);
            $expiration = config('sanctum.expiration');
            $isValid = (! $expiration || $accessToken->created_at->gt(now()->subMinutes($expiration)));
            if($isValid) {
                $user=$accessToken->tokenable;
            }else{
                abort(403, 'Patmos: Token inválido.');
            }
            //dd($request->header('AuthorizationStrategy'),$access_token,$accessToken,$isValid,$accessToken->tokenable);
        }elseif($request->is('api/canvas/*')){

        }else {
            abort(500, 'Lamb: Ingrese una estratégia válida de autenticación');
        }
        return $user;
    }

    private static function getStrategyName(Request $request)
    {
        return $request->header('AuthorizationStrategy');
    }

    private static function getUsernameLamb(Request $request)
    {

        $access_token = $request->bearerToken();
        $user=User::where('access_token', $access_token)
            ->where('updated_token','>',Carbon::now()->subDays(5))
            ->first();

        $data = [];
        //dd($user?->updated_token,Carbon::now()->subDays(5)->toDateTimeString());
        if(!$user){
            if (!$access_token) {
                abort(403, 'Lamb: Token inválido.');
            }
            $username = null;
            $response = Http::asForm()
                ->withToken(env('LAMB_AUTH_INTROSPECT_TOKEN', ''))
                ->post(env('LAMB_AUTH_INTROSPECT_ENDPOINT'), ['token' => $access_token]);
            //dd($response);
            if ($response->status() == 401) {
                abort(401, 'Lamb: No autorizado, token inválido.');
            } elseif ($response->status() == 200 && !$response->json()['active']) {
                abort(401, 'Lamb: No autorizado, token caducado.');
            } elseif ($response->status() == 403) {
                abort(403, 'Lamb: Prohibido, token de introspección inválido.');
            } elseif ($response->status() == 200 && $response->json()['active']) {
                $data=$response->json();
                $username = $response->json()['username'];
                $updated_token=Carbon::now()->timezone('UTC')->format('Y-m-d H:i:s');
                //dd($updated_token,$username);
                User::where('usuario_upeu',$username)->update(['access_token' =>$access_token,'updated_token'=>$updated_token]);
            } else {
                abort(401, 'Lamb: Auth inválido.');
            }

        }else{
            $username=$user->usuario_upeu;
        }

        return [$username,$data];
    }

    private static function getEmailGoogle(Request $request)
    {

        $access_token = $request->bearerToken();
        if (!$access_token) {
            abort(403, 'Google: Token inválido.');
        }
        $username = null;
        $data=[];

        $response = Http::post(env('LAMB_AUTH_TOKEN_INFO_GOOGLE_ENDPOINT'), [
            'access_token' => $access_token
        ]);

        if ($response->status() == 200) {
            //abort(500,$response);
            $data= $response->json() ;
            $username= $response->json()['sub'];
        } else {
            abort(401, 'Google: No autorizado, token caducado o inválido.');
        }
        return [$username,$data];

    }

    private static function getEmailAzure(Request $request)
    {

        $access_token = $request->bearerToken();

        if (!$access_token) {
            abort(403, 'Azure: Token inválido.');
        }
        $email = null;
        $data =[];

        $response = Http::post(env('LAMB_AUTH_TOKEN_INFO_AZURE_ENDPOINT'), [
            'access_token' => $access_token
        ]);
        if ($response->status() == 200) {
            $data= $response->json();
            $email = $response->json('email');
        } else {
            abort(401, 'Azure: No autorizado, token caducado o inválido.');
        }
        return [$email,$data];

    }

    private static function newUsuarioLamb($userKey){
        $token = env('LAMB_AUTH_INTROSPECT_TOKEN', '');
        $authHeader = "Authorization: $token";
        $postHeaders = array(
            $authHeader, 'Content-Type: application/json'
        );
        //Inicializamos
        $url
            = "https://api-lamb-academic.upeu.edu.pe/resources/api/resources/user?usuario="
            .$userKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $postHeaders);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $curlResponse = curl_exec($ch);

        //Gestión de erorres
        $curlErrno = curl_errno($ch);
        if ($curlErrno) {
            $curlError = curl_error($ch);
            //echo $curlError;
            $response = [
                'success' => true,
                'message' => $curlError,
                'meta'    => null,
                'errors'  => true
            ];

            abort(400, 'Error desconocido');
            //return response()->json($response, 400);
        }

        $jsonArrayResponse = json_decode($curlResponse);
        if ($jsonArrayResponse->success) {
            $datoUpeu = $jsonArrayResponse->data[0];
            if (filter_var($datoUpeu->correo_upeu,
                    FILTER_VALIDATE_EMAIL)
                && (preg_match('/^([a-z0-9_\.-]+)@upeu\.edu\.pe$/',
                        $datoUpeu->correo_upeu) or preg_match('/^([a-z0-9_\.-]+)@colegiounion\.edu\.pe$/',
                        $datoUpeu->correo_upeu))
            ) {
                $input = [
                    'email'                 => $datoUpeu->correo_upeu,
                    "name"                  => $datoUpeu->nombres,
                    "apellido_paterno"      => $datoUpeu?->apellido_paterno,
                    "apellido_materno"      => $datoUpeu?->apellido_materno,
                    "dni"                   => $datoUpeu->dni,
                    "codigo"                => $datoUpeu->codigo,
                    "password"              => "myUpeu2021",
                    "password_confirmation" => "myUpeu2021",
                    "celular"               => $datoUpeu->codigo,
                    "correo_upeu"           => $datoUpeu->codigo,
                    "id_persona"            => $datoUpeu->id_persona,
                    "usuario_upeu"          => $datoUpeu->usuario,
                    'tipo_rol'              => 'Estudiante',
                ];
                $create = new CreateNewUser();
                $create->create($input);
            }else{
                $input_ = [
                    'email'                 => $datoUpeu->usuario.'@upeu.edu.pe',
                    "name"                  => $datoUpeu->nombres,
                    "apellido_paterno"      => $datoUpeu?->apellido_paterno,
                    "apellido_materno"      => $datoUpeu?->apellido_materno,
                    "dni"                   => $datoUpeu->dni,
                    "codigo"                => $datoUpeu->codigo,
                    "password"              => "myUpeu2021",
                    "password_confirmation" => "myUpeu2021",
                    "celular"               => $datoUpeu->codigo,
                    "correo_upeu"           => $datoUpeu->codigo,
                    "id_persona"            => $datoUpeu->id_persona,
                    "usuario_upeu"          => $datoUpeu->usuario,
                    'tipo_rol'              => 'Estudiante',
                ];
                $create = new CreateNewUser();
                $create->create($input_);
            }
            curl_close($ch);

        }
    }

    private static function newUsuarioGoogle(Request $request){
        $access_token = $request->bearerToken();

        $userGoogle = Socialite::driver('google')
            ->userFromToken($access_token);
        if ($userGoogle->user) {
            $input = [
                'email'                 => $userGoogle->email,
                "name"                  => $userGoogle->user['given_name'],
                "apellido_paterno"      => $userGoogle->user['family_name'],
                "apellido_materno"      => '-',
                "dni"                   => substr($userGoogle->id,-8),
                "codigo"                => date('Y').date('m').date('d').date('v'),
                "social_id"              => $userGoogle->id,
                "social_type"              => "google",
                "password"              => "myUpeu2021",
                "password_confirmation" => "myUpeu2021",
                "celular"               => '-',
                "correo_upeu"           => null,
                "correo_externo"           => $userGoogle->email,
                'tipo_rol'              => 'Estudiante',
                'usuario_temporal'              => '1',
                'profile_photo_path'    =>$userGoogle->user['picture']
            ];
            $create = new CreateNewUser();
            $create->create($input);
        } else {
            abort(401, 'Google: No autorizado, token caducado o inválido.');
        }


    }

    private static function newUsuarioAzure(Request $request){

        $access_token = $request->bearerToken();

        if (!$access_token) {
            abort(403, 'Azure: Token inválido.');
        }
        $response = Http::post(env('LAMB_AUTH_TOKEN_INFO_AZURE_ENDPOINT'), [
            'access_token' => $access_token
        ]);
        if ($response->status() == 200) {
            $input = [
                'email'                 => $response->json('email'),
                "name"                  => $response->json('name'),
                "apellido_paterno"      => $response->json('family_name'),
                "apellido_materno"      => $response->json('given_name'),
                "dni"                   => $response->json('sub'),
                "codigo"                => date('Y').date('M').date('D').date('v'),
                "password"              => "myUpeu2021",
                "password_confirmation" => "myUpeu2021",
                "celular"               => '-',
                "correo_upeu"           =>'-',
                "id_persona"            => '-',
                "usuario_upeu"          => '-',
                "microsoft_id"          => $response->json('email'),
                "correo_externo"          => $response->json('email'),
                'tipo_rol'              => 'Estudiante',
                'profile_photo_path'    =>NULL,
            ];
            $create = new CreateNewUser();
            $create->create($input);
        } else {
            abort(401, 'Azure: No autorizado, token caducado o inválido.');
        }

    }

}
