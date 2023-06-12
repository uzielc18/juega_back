<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Resources\SettingResource;
use App\Http\Resources\SettingCollection;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return SettingCollection
     */
    public function index(Request $request)
    {
        return new SettingCollection(Setting::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return SettingResource
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $setting = Setting::create($requestData);
        return (new SettingResource($setting))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Setting $setting
     * @return SettingResource
     */
    public function show(Setting $setting)
    {
        return new SettingResource($setting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Setting $setting
     * @return SettingResource
     */
    public function update(Request $request, Setting $setting)
    {
        $requestData = $request->all();
        $setting->update($requestData);
        return (new SettingResource($setting))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Setting $setting
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted!',
            'meta' => null,
            'errors' => null
        ], 200);
    }
}
