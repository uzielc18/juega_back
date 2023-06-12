<?php


use App\Http\Controllers\Api\SettingController;

use App\Http\Controllers\Api\ResultadoController;

use App\Http\Controllers\Api\InfoequipoController;

use App\Http\Controllers\Api\EtapaController;

use App\Http\Controllers\Api\EquipojugadoreController;

use App\Http\Controllers\Api\EquipoController;

use App\Http\Controllers\Api\EncuentroController;

use App\Http\Controllers\Api\DisciplinaController;

use App\Http\Controllers\Api\CategoriasEquipoController;

use App\Http\Controllers\Api\CampeonatoController;

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    //return $request->user();
});
Route::apiResource('users', UserController::class);
Route::apiResource('campeonatos', CampeonatoController::class);
Route::apiResource('categoriasEquipos', CategoriasEquipoController::class);
Route::apiResource('disciplinas', DisciplinaController::class);
Route::apiResource('encuentros', EncuentroController::class);
Route::apiResource('equipos', EquipoController::class);
Route::apiResource('equipojugadores', EquipojugadoreController::class);
Route::apiResource('etapas', EtapaController::class);
Route::apiResource('infoequipos', InfoequipoController::class);
Route::apiResource('resultados', ResultadoController::class);
Route::apiResource('settings', SettingController::class);
