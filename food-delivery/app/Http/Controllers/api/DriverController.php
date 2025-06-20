<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DriverRequest;
use App\Http\Resources\DriverResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = \App\Models\Driver::all();

        return (DriverResource::collection($drivers))
            -> response()
            ->setStatusCode(200);
    }

    public function store(DriverRequest $request)
    {
        $driver = \App\Models\Driver::create($request->validated());

        return (new DriverResource($driver))
            -> response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        $driver = \App\Models\Driver::where('id', $id)->first();

        if (!$driver) {
            return response()->json([
                'status' => 'error',
                'message' => 'Driver not found',
            ], 404);
        }

        return (new DriverResource($driver))
            ->response()
            ->setStatusCode(200);
    }

    public function update(DriverRequest $request, $id)
    {
        $driver = \App\Models\Driver::where('id', $id)->first();

        if (!$driver) {
            return response()->json([
                'status' => 'error',
                'message' => 'Driver not found',
            ], 404);
        }

        $driver->update($request->validated());

        return (new DriverResource($driver))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy($id)
    {
        $driver = \App\Models\Driver::where('id', $id)->first();

        if (!$driver) {
            return response()->json([
                'status' => 'error',
                'message' => 'Driver not found',
            ], 404);
        }

        $driver->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Customer deleted successfully',
        ], 200);
    }

    public function getOrders(Request $request){
        $users = Auth::user();
        $merchant = \App\Models\Driver::where('user_id', $users->id)->first();
        $order = \App\Models\Order::where('location', 'like', '%', $request->search. '%');

    }
}
