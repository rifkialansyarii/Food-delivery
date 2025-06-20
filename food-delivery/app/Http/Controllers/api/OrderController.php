<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::all();
        return (OrderResource::collection($orders))
            ->response()
            ->setStatusCode(200);
    }

    public function store(OrderRequest $request)
    {
        $user = Auth::user();
        $payload = $request->validated();
        $payload['user_id'] = $user->id; // Assuming the authenticated user is the customer
        // Create a new order
        $order = Order::create($payload);

        // Return the created order as a JSON response
        return (new OrderResource($order))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        $order = \App\Models\Order::where('id', $id)->first();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        return (new OrderResource($order))
            ->response()
            ->setStatusCode(200);
    }

    public function update(OrderRequest $request, $id)
    {
        $order = \App\Models\Order::where('id', $id)->first();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        $order->update($request->validated());

        return (new OrderResource($order))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy($id)
    {
        $order = \App\Models\Order::where('id', $id)->first();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        $order->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Order deleted successfully',
        ], 200);
    }    

}

