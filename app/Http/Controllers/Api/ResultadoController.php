<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Resultado;
use App\Http\Resources\ResultadoResource;
use App\Http\Resources\ResultadoCollection;

class ResultadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return ResultadoCollection
     */
    public function index(Request $request)
    {
        return new ResultadoCollection(Resultado::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ResultadoResource
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $resultado = Resultado::create($requestData);
        return (new ResultadoResource($resultado))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Resultado $resultado
     * @return ResultadoResource
     */
    public function show(Resultado $resultado)
    {
        return new ResultadoResource($resultado);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Resultado $resultado
     * @return ResultadoResource
     */
    public function update(Request $request, Resultado $resultado)
    {
        $requestData = $request->all();
        $resultado->update($requestData);
        return (new ResultadoResource($resultado))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Resultado $resultado
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Resultado $resultado)
    {
        $resultado->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted!',
            'meta' => null,
            'errors' => null
        ], 200);
    }
}
