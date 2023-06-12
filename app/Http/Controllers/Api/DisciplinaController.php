<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Disciplina;
use App\Http\Resources\DisciplinaResource;
use App\Http\Resources\DisciplinaCollection;

class DisciplinaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return DisciplinaCollection
     */
    public function index(Request $request)
    {
        return new DisciplinaCollection(Disciplina::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return DisciplinaResource
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $disciplina = Disciplina::create($requestData);
        return (new DisciplinaResource($disciplina))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Disciplina $disciplina
     * @return DisciplinaResource
     */
    public function show(Disciplina $disciplina)
    {
        return new DisciplinaResource($disciplina);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Disciplina $disciplina
     * @return DisciplinaResource
     */
    public function update(Request $request, Disciplina $disciplina)
    {
        $requestData = $request->all();
        $disciplina->update($requestData);
        return (new DisciplinaResource($disciplina))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Disciplina $disciplina
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Disciplina $disciplina)
    {
        $disciplina->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted!',
            'meta' => null,
            'errors' => null
        ], 200);
    }
}
