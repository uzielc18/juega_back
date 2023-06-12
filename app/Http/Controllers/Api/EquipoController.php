<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Http\Resources\EquipoResource;
use App\Http\Resources\EquipoCollection;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return EquipoCollection
     */
    public function index(Request $request)
    {
        return new EquipoCollection(Equipo::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return EquipoResource
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $equipo = Equipo::create($requestData);
        return (new EquipoResource($equipo))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Equipo $equipo
     * @return EquipoResource
     */
    public function show(Equipo $equipo)
    {
        return new EquipoResource($equipo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Equipo $equipo
     * @return EquipoResource
     */
    public function update(Request $request, Equipo $equipo)
    {
        $requestData = $request->all();
        $equipo->update($requestData);
        return (new EquipoResource($equipo))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Equipo $equipo
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Equipo $equipo)
    {
        $equipo->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted!',
            'meta' => null,
            'errors' => null
        ], 200);
    }
}
