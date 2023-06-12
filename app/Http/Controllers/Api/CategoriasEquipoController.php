<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\CategoriasEquipo;
use App\Http\Resources\CategoriasEquipoResource;
use App\Http\Resources\CategoriasEquipoCollection;

class CategoriasEquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CategoriasEquipoCollection
     */
    public function index(Request $request)
    {
        return new CategoriasEquipoCollection(CategoriasEquipo::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return CategoriasEquipoResource
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $categoriasEquipo = CategoriasEquipo::create($requestData);
        return (new CategoriasEquipoResource($categoriasEquipo))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param CategoriasEquipo $categoriasEquipo
     * @return CategoriasEquipoResource
     */
    public function show(CategoriasEquipo $categoriasEquipo)
    {
        return new CategoriasEquipoResource($categoriasEquipo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param CategoriasEquipo $categoriasEquipo
     * @return CategoriasEquipoResource
     */
    public function update(Request $request, CategoriasEquipo $categoriasEquipo)
    {
        $requestData = $request->all();
        $categoriasEquipo->update($requestData);
        return (new CategoriasEquipoResource($categoriasEquipo))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CategoriasEquipo $categoriasEquipo
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(CategoriasEquipo $categoriasEquipo)
    {
        $categoriasEquipo->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted!',
            'meta' => null,
            'errors' => null
        ], 200);
    }
}
