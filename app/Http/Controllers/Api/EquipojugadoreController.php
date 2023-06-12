<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Equipojugadore;
use App\Http\Resources\EquipojugadoreResource;
use App\Http\Resources\EquipojugadoreCollection;

class EquipojugadoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return EquipojugadoreCollection
     */
    public function index(Request $request)
    {
        return new EquipojugadoreCollection(Equipojugadore::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return EquipojugadoreResource
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $equipojugadore = Equipojugadore::create($requestData);
        return (new EquipojugadoreResource($equipojugadore))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Equipojugadore $equipojugadore
     * @return EquipojugadoreResource
     */
    public function show(Equipojugadore $equipojugadore)
    {
        return new EquipojugadoreResource($equipojugadore);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Equipojugadore $equipojugadore
     * @return EquipojugadoreResource
     */
    public function update(Request $request, Equipojugadore $equipojugadore)
    {
        $requestData = $request->all();
        $equipojugadore->update($requestData);
        return (new EquipojugadoreResource($equipojugadore))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Equipojugadore $equipojugadore
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Equipojugadore $equipojugadore)
    {
        $equipojugadore->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted!',
            'meta' => null,
            'errors' => null
        ], 200);
    }
}
