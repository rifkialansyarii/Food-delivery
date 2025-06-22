<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DriverGetOrderRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\UpdateOrderDriverRequest;
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

        $order = Order::where('location', 'like', '%' . $payload["lokasi"] . '%')
        ->where("status", "pending")
        ->latest()
        ->get();

        return $order;
    }

    function driverHistoryOrder() {
        $user = Auth::user();
        $order = Order::where("driver_id", $user->id)
            ->where("is_done", true)
            ->get();
        return $order;
    }

    function merchantHistoryOrder() {
        $user = Auth::user();
        $merchant = Merchant::firstWhere("user_id", $user->id);
        $order = Order::where("merchant_id", $merchant->id)
            ->where("is_done", true)
            ->get();
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

        if ($latestOrder) {
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
        $order = Order::where('id', $id)->first();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        return $order;
    }

    public function update(OrderRequest $request, $id)
    {
        $order = Order::where('id', $id)->first();

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
        $order = Order::where('id', $id)->first();

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

    function updateStatusOrder(string $id, UpdateOrderDriverRequest $request) {
        $payload = $request->validated();
        $order = Order::firstWhere("id", $id);
        
        if ($payload["is_done"]) {
            $order->is_done = $payload["is_done"];
            $order->status = "selesai";
            $order->save();
        } else if ($payload["is_diambil"]) {
            $order->is_diambil = $payload["is_diambil"];
            $order->status = "diantar";
            $order->save();
        }

        return $order;
    }
}

