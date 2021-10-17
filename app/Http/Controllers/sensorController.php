<?php

namespace App\Http\Controllers;

use App\Events\SensorReports;

use App\Jobs\SendEmailNotificationJob;
use App\Models\sensorType;
use App\Models\sensorData;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class sensorController extends Controller
{
    /**
     * Display a listing of the resource.
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
            'value' => 'required|array',
            'location' => 'required',
            'sensorID' => 'required',
        ]);

       // Log::channel('customMonolog')->debug("Request Debug", [$request->all()]);
        $sensorData = sensorData::create($request->all());
        // Trigger email event.
        //event(new SensorReports($sensorData));

//        ProcessPodcast::dispatchIf($accountActive, $podcast);
//
//        ProcessPodcast::dispatchUnless($accountSuspended, $podcast);

//    use Illuminate\Support\Facades\Bus;
//
//        Bus::chain([
//            new ProcessPodcast,
//            new OptimizePodcast,
//            new ReleasePodcast,
//        ])->dispatch();
        //SendEmailNotificationJob::dispatch($sensorData)->onQueue('database');
        SendEmailNotificationJob::dispatch($sensorData)->onConnection('database')->onQueue('default');
       // SensorReports::dispatch($sensorData);
        return \response()->json("", 200);

     //   return response()->json($sensorData, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return
     */
    public function show(int $id)
    {
        $sensorData = sensorData::findOrFail($id);
        return response()->json($sensorData, 200);
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
