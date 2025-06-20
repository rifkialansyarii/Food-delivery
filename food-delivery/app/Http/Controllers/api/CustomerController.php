<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = \App\Models\Customer::all();

        return (CustomerResource::collection($customers))
            -> response()
            ->setStatusCode(200);
    }

    public function store(CustomerRequest $request)
    {
        $customer = \App\Models\Customer::create($request->validated());

        return (new CustomerResource($customer))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        $customer = \App\Models\Customer::where('id', $id)->first();

        if (!$customer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Customer not found',
            ], 404);
        }

        return (new CustomerResource($customer))
            ->response()
            ->setStatusCode(200);
    }

    public function update(CustomerRequest $request, $id)
    {
        $customer = \App\Models\Customer::where('id', $id)->first();

        if (!$customer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Customer not found',
            ], 404);
        }

        $customer->update($request->validated());

        return (new CustomerResource($customer))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy($id)
    {
        $customer = \App\Models\Customer::where('id', $id)->first();

        if (!$customer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Customer not found',
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Customer deleted successfully',
        ], 200);
    }
}
