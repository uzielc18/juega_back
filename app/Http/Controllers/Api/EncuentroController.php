<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Encuentro;
use App\Http\Resources\EncuentroResource;
use App\Http\Resources\EncuentroCollection;

class EncuentroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return EncuentroCollection
     */
    public function index(Request $request)
    {
        return new EncuentroCollection(Encuentro::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return EncuentroResource
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $encuentro = Encuentro::create($requestData);
        return (new EncuentroResource($encuentro))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Encuentro $encuentro
     * @return EncuentroResource
     */
    public function show(Encuentro $encuentro)
    {
        return new EncuentroResource($encuentro);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Encuentro $encuentro
     * @return EncuentroResource
     */
    public function update(Request $request, Encuentro $encuentro)
    {
        $requestData = $request->all();
        $encuentro->update($requestData);
        return (new EncuentroResource($encuentro))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Encuentro $encuentro
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Encuentro $encuentro)
    {
        $encuentro->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted!',
            'meta' => null,
            'errors' => null
        ], 200);
    }
}
