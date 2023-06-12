<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Infoequipo;
use App\Http\Resources\InfoequipoResource;
use App\Http\Resources\InfoequipoCollection;

class InfoequipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return InfoequipoCollection
     */
    public function index(Request $request)
    {
        return new InfoequipoCollection(Infoequipo::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return InfoequipoResource
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $infoequipo = Infoequipo::create($requestData);
        return (new InfoequipoResource($infoequipo))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Infoequipo $infoequipo
     * @return InfoequipoResource
     */
    public function show(Infoequipo $infoequipo)
    {
        return new InfoequipoResource($infoequipo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Infoequipo $infoequipo
     * @return InfoequipoResource
     */
    public function update(Request $request, Infoequipo $infoequipo)
    {
        $requestData = $request->all();
        $infoequipo->update($requestData);
        return (new InfoequipoResource($infoequipo))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Infoequipo $infoequipo
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Infoequipo $infoequipo)
    {
        $infoequipo->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted!',
            'meta' => null,
            'errors' => null
        ], 200);
    }
}
