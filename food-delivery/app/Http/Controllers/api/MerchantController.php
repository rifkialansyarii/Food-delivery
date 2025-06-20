<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MerchantRequest;
use App\Http\Resources\MerchantResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantController extends Controller
{
    public function index(Request $request)
    {   
        $merchants = \App\Models\Merchant::all();
        return (MerchantResource::collection($merchants))
            -> response()
            ->setStatusCode(200);
    }

    public function store(MerchantRequest $request)
    {

        // Create a new merchant
        $merchant = \App\Models\Merchant::create($request->validated());

        // Return the created merchant as a JSON response
        return (new MerchantResource($merchant))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        $merchant = \App\Models\Merchant::where('id', $id)->first();

        if (!$merchant) {
            return response()->json([
                'status' => 'error',
                'message' => 'Merchant not found',
            ], 404);
        }

        return (new MerchantResource($merchant))
            ->response()
            ->setStatusCode(200);
    }

    public function update(MerchantRequest $request, $id)
    {
        $merchant = \App\Models\Merchant::where('id', $id)->first();

        if (!$merchant) {
            return response()->json([
                'status' => 'error',
                'message' => 'Merchant not found',
            ], 404);
        }

        $merchant->update($request->validated());

        return (new MerchantResource($merchant))
            ->response()
            ->setStatusCode(200);
    }    

    public function destroy($id)
    {
        $merchant = \App\Models\Merchant::where('id', $id)->first();

        if (!$merchant) {
            return response()->json([
                'status' => 'error',
                'message' => 'Merchant not found',
            ], 404);
        }

        $merchant->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Merchant deleted successfully',
        ], 200);
    }

    public function getOrders(){
        $users = Auth::user();
        $merchant = \App\Models\Merchant::where('user_id', $users->id)->first();
        $order = \App\Models\Order::where('status', 'open')->orWhere('merchant_id', $merchant->id)->get();




    }
}

