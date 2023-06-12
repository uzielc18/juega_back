<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Etapa;
use App\Http\Resources\EtapaResource;
use App\Http\Resources\EtapaCollection;

class EtapaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return EtapaCollection
     */
    public function index(Request $request)
    {
        return new EtapaCollection(Etapa::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return EtapaResource
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $etapa = Etapa::create($requestData);
        return (new EtapaResource($etapa))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Etapa $etapa
     * @return EtapaResource
     */
    public function show(Etapa $etapa)
    {
        return new EtapaResource($etapa);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Etapa $etapa
     * @return EtapaResource
     */
    public function update(Request $request, Etapa $etapa)
    {
        $requestData = $request->all();
        $etapa->update($requestData);
        return (new EtapaResource($etapa))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Etapa $etapa
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Etapa $etapa)
    {
        $etapa->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted!',
            'meta' => null,
            'errors' => null
        ], 200);
    }
}
