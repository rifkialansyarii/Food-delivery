<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DriverGetOrderRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\DetailOrder;
use App\Models\Merchant;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $orders = Order::where("user_id", $user->id)->get();
        return $orders;
        // return (OrderResource::collection($orders))
        //     ->response()
        //     ->setStatusCode(200);
    }

    function getCurrentOrder() {
        $user = Auth::user();

        $orders = Order::where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('is_done', false);
            })->latest()->first();
        return $orders;
    }

    function merchantGetOrder() {
        $user = Auth::user();
        $merchant = Merchant::firstWhere("user_id", $user->id);
        $orders = Order::where("merchant_id", $merchant->id)->get();

        return $orders;
    }

    function driverGetOrder(DriverGetOrderRequest $request) {
        $payload = $request->validated();

        $order = Order::where('location', 'like', '%' . $payload["lokasi"] . '%')->get();

        return $order;
    }

    function driverTakeOrder(string $id) {
        $user = Auth::user();
        $order = Order::firstWhere("id", $id);

        if ($order->is_taken == true) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order already taken',
            ], 422);
        }

        $order->is_taken = true;
        $order->driver_id = $user->id;
        $order->save();

        return $order;
    }

    public function store(OrderRequest $request)
    {
        $user = Auth::user();
        $payload = $request->validated();
        
        $latestOrder = Order::firstWhere("user_id", $user->id);

        if ($latestOrder->is_done == false) {
            foreach ($payload["menu"] as $menu) {
                $detailOrder = DetailOrder::create();
                $detailOrder->order_id = $latestOrder->id;
                $detailOrder->user_id =  $user->id;
                $detailOrder->menu_id = $menu["id"];
                $detailOrder->stok = $menu["stok"];
                $detailOrder->merchant_id = $payload["merchant_id"];
                $detailOrder->catatan = $menu["catatan"];
                $detailOrder->save();

                return $latestOrder;
            }
        } else {
            // Create a new order
            $order = Order::create($payload);
            $order->user_id = $user->id;
            $order->is_done = false;
            $order->merchant_id = $payload["merchant_id"];
            $order->latitude = $payload["latitude"];
            $order->longtitude = $payload["longtitude"];
            $order->save();

            foreach ($payload["menu"] as $menu) {
                $detailOrder = DetailOrder::create();
                $detailOrder->order_id = $order->id;
                $detailOrder->user_id =  $user->id;
                $detailOrder->menu_id = $menu["id"];
                $detailOrder->stok = $menu["stok"];
                $detailOrder->merchant_id = $payload["merchant_id"];
                $detailOrder->catatan = $menu["catatan"];
                $detailOrder->save();
            }

            return $order;
        }
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

