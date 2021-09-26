<?php

namespace App\Http\Controllers;

use App\Events\SensorDataSaved;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\sensorData;
use App\Models\sensorType;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class sensorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        return sensorData::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'value' => 'required',
            'location' => 'required',
            'sensorID' => 'required',
        ]);
       // Log::channel('customMonolog')->debug("Request Debug", [$request->all()]);\
        $sensorData = sensorData::create($request->all());
//        $typeID = $request->get('sensor_type_id');
//        $sensorType = sensorType::findOrFail($typeID);
       // Log::channel('customMonolog')->debug("Request Debug", [$request->all()]);

        event(new SensorDataSaved($sensorData));
        return response()->json($sensorData, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $sensorData = sensorData::findOrFail($id);
        return $sensorData;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id): Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id): Response
    {
        //
    }
}
