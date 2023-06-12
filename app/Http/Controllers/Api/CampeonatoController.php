<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Campeonato;
use App\Http\Resources\CampeonatoResource;
use App\Http\Resources\CampeonatoCollection;

class CampeonatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CampeonatoCollection
     */
    public function index(Request $request)
    {
        return new CampeonatoCollection(Campeonato::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return CampeonatoResource
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $campeonato = Campeonato::create($requestData);
        return (new CampeonatoResource($campeonato))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Campeonato $campeonato
     * @return CampeonatoResource
     */
    public function show(Campeonato $campeonato)
    {
        return new CampeonatoResource($campeonato);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Campeonato $campeonato
     * @return CampeonatoResource
     */
    public function update(Request $request, Campeonato $campeonato)
    {
        $requestData = $request->all();
        $campeonato->update($requestData);
        return (new CampeonatoResource($campeonato))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Campeonato $campeonato
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Campeonato $campeonato)
    {
        $campeonato->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted!',
            'meta' => null,
            'errors' => null
        ], 200);
    }
}
